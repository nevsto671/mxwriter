<?php

namespace Controller\User;

use DB;
use Controller\UserController;

class Editor extends UserController
{
    private $template;
    private $language;
    private $tone;
    private $data;

    public function index()
    {
        $user = $this->userDetails(['id' => $this->uid], 'plan_id, words_generated, words, images');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;

        // get template
        if (isset($_GET['tid']) && is_string($_GET['tid']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $this->getForm($_GET['tid']);
        }

        // save doc
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['text'])) {
            $total = DB::count('documents', ['user_id' => $this->uid]);
            $doc_allow = isset($plan['documents']) ? $plan['documents'] : 10;
            $doc_over = !is_null($doc_allow) && $total >= $doc_allow ? true : false;
            if ($doc_over) exit;

            $doc_id = !empty($_POST['doc']) && is_string($_POST['doc']) ? $_POST['doc'] : null;
            $text = isset($_POST['text']) && is_string($_POST['text']) ? $_POST['text'] : null;
            $name = !empty($_POST['name']) && is_string($_POST['name']) && trim($_POST['name']) ? strip_tags(trim($_POST['name'])) : 'New Document';
            $name = mb_strimwidth($name, 0, 200, '...', 'utf-8');
            $data['text'] = $text;
            $data['modified'] = date('Y-m-d H:i:s');
            if ($doc_id) {
                $document = DB::select('documents', '*', ['id' => $doc_id, 'user_id' => $this->uid], 'LIMIT 1');
                if ($document && $text) {
                    DB::update('documents', $data, ['id' => $doc_id]);
                    $this->output(['doc' => $doc_id]);
                }
            }

            $data['name'] = $name;
            $data['created'] = date('Y-m-d H:i:s');
            $data['user_id'] = $this->uid;
            $data['id'] =  md5($this->uid . microtime(true) . rand()) . uniqid();
            $data['folder_id'] = !empty($_POST['folder_id']) && is_string($_POST['folder_id']) ? $_POST['folder_id'] : 1;
            DB::insert('documents', $data);

            // update usages
            $usage_documents_result = DB::select('usages', 'id, documents', ['user_id' => $this->uid, 'date' => date('Y-m-d')], 'LIMIT 1');
            if (!empty($usage_documents_result[0])) {
                DB::update('usages', ['documents' => $usage_documents_result[0]['documents'] + 1], ['id' => $usage_documents_result[0]['id']]);
            } else {
                DB::insert('usages', ['user_id' => $this->uid, 'documents' => 1, 'date' => date('Y-m-d')]);
            }

            $this->output(['doc' => $data['id']]);
        }

        // view
        $doc_id = !empty($_GET['d']) && is_string($_GET['d']) ? $_GET['d'] : null;
        $hst_id = !empty($_GET['h']) && is_string($_GET['h']) ? $_GET['h'] : null;
        $text = null;
        $language = null;
        $tone = null;
        if ($doc_id) {
            $document = DB::select('documents', '*', ['id' => $doc_id, 'user_id' => $this->uid], 'LIMIT 1');
            $text = isset($document[0]['text']) ? $document[0]['text'] : null;
        } else if ($hst_id) {
            $history = DB::select('history', '*', ['id' => $hst_id, 'user_id' => $this->uid], 'LIMIT 1');
            $text = isset($history[0]['text']) ? $history[0]['text'] : null;
            $template_id = isset($history[0]['template_id']) ? $history[0]['template_id'] : 0;
            $language = isset($history[0]['language']) ? $history[0]['language'] : null;
            $tone = isset($history[0]['tone']) ? $history[0]['tone'] : null;
            $data = !empty($history[0]['data']) ? json_decode($history[0]['data'], true) : [];
            $result = DB::select('templates', 'id, slug', ['id' => $template_id], 'LIMIT 1');
            $slug = isset($result[0]['slug']) ? ($result[0]['slug'] . '-' . base64_encode($result[0]['id'])) : null;
            if ($slug && empty($_GET['t'])) $this->redirect("my/editor?h=$hst_id&t=$slug");
        }

        if (isset($_GET['t']) && is_string($_GET['t'])) {
            $templateId = base64_decode(array_slice(explode('-', $_GET['t']), -1)[0]);
            $result = DB::select('templates', '*', ['id' => $templateId], 'LIMIT 1');
            $template = isset($result[0]) ? $result[0] : null;
            if (empty($template)) $this->redirect("my/editor");
            $languages = $this->languages();
            $tones = $this->tones();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // check user openai apikey
                if (!empty($plan['own_api']) && $this->user['openai_status'] && !$this->user['openai_apikey']) $this->output(['error' => 'result_error', 'message' => "Please enter your OpenAI API key from your account details."]);

                // check premium template access permission
                if (!empty($template['premium']) && empty($plan['premium'])) $this->output(['error' => 'no_access']);

                // check usges
                $remaining_words = isset($user['words']) ? (int) $user['words'] : null;
                if (!is_null($remaining_words) && $remaining_words == 0) $this->output(['error' => 'no_credits']);

                // generate results
                $results = $this->raitor($templateId);
                if (empty($results)) $this->output(['error' => 'result_error']);
                $error_code = isset($results['error']['code']) ? $results['error']['code'] : null;
                $error_message = isset($results['error']['message']) ? $results['error']['message'] : null;
                $errorMessage = $this->rid == 1 ? $error_message : null;
                if (isset($results['error'])) $this->output(['error' => 'api_error', 'message' => $errorMessage]);

                if (empty($results['id'])) return null;
                $tokenCount = $results['usage']['completion_tokens'];
                $total_tokens = $results['usage']['total_tokens'];
                $output["results"] = [];
                $content = '';
                if (empty($results['choices'])) $this->output(['error' => 'no_results']);
                $total_results = count($results['choices']);
                foreach ($results['choices'] as $key => $val) {
                    $content = isset($val['message']['content']) ? $val['message']['content'] : null;
                    $output["results"][$key] = $content;
                    // insert history
                    if ($content) $this->insertHistory($this->template, $content);
                }

                // token to word
                $wordCount = round($tokenCount * 0.75);

                // update usages
                $usage_words_result = DB::select('usages', 'id, words', ['user_id' => $this->uid, 'date' => date('Y-m-d')], 'LIMIT 1');
                if (!empty($usage_words_result[0])) {
                    $usges_words = $usage_words_result[0]['words'] + $wordCount;
                    DB::update('usages', ['words' => $usges_words], ['id' => $usage_words_result[0]['id']]);
                } else {
                    DB::insert('usages', ['user_id' => $this->uid, 'words' => $wordCount, 'date' => date('Y-m-d')]);
                }

                // update user
                if (!is_null($remaining_words)) {
                    $words_generated = $user['words_generated'] + $wordCount;
                    $remaining_words = $remaining_words >= $wordCount ? ($remaining_words - $wordCount) : 0;
                    DB::update('users', ['words_generated' => $words_generated, 'words' => $remaining_words], ['id' => $this->uid]);
                }

                // add recent history
                DB::delete('recent_history', ['user_id' => $this->uid, 'template_id' => $templateId, 'type' => 'template']);
                DB::insert('recent_history', ['user_id' => $this->uid, 'template_id' => $templateId, 'type' => 'template']);

                // output
                $output["credits"] = $remaining_words;
                $this->output($output);
            }
        }

        $folders = DB::select('folders', '*', ['user_id' => $this->uid], 'ORDER BY created DESC');
        $templates =  DB::select('templates', 'id, title, slug, color, premium, icon', ['status' => 1]);
        $this->title('Smart Editor');
        require_once APP . '/View/User/Editor.php';
    }

    public function languages($language = null)
    {
        if ($language) {
            $result = DB::select('languages', '*', ['name' => $language], 'LIMIT 1');
            return $result ? true : false;
        }
        $results = DB::select('languages', '*', ['status' => 1], 'ORDER by name ASC');
        return $results ? $results : [];
    }

    public function tones($tone = null)
    {
        if ($tone) {
            $result = DB::select('tones', '*', ['name' => $tone], 'LIMIT 1');
            return $result ? true : false;
        }
        $results = DB::select('tones', '*', ['status' => 1], 'ORDER by name ASC');
        return $results ? $results : [];
    }

    public function templates($id = null, $group = null)
    {
        if ($id) {
            $result = DB::query("select templates.*, models.model From templates LEFT JOIN models ON templates.model=models.id WHERE templates.status=1 AND templates.id='$id' LIMIT 1");
            return isset($result[0]) ? $result[0] : [];
        }
        if ($group) $group = "GROUP BY group_name";
        $results = DB::query("select templates.*, models.model From templates LEFT JOIN models ON templates.model=models.id WHERE status=1 $group ORDER BY templates.title ASC");
        return isset($results) ? $results : [];
    }

    public function raitor($templateId)
    {
        $fields = isset($_POST['fields']) ? $_POST['fields'] : [];
        $language = isset($_POST['language']) && is_string($_POST['language']) && $this->languages(strip_tags($_POST['language'])) ? $_POST['language'] : 'English';
        $tone = isset($_POST['tone']) && is_string($_POST['tone']) && $this->tones(strip_tags($_POST['tone'])) ? $_POST['tone'] : null;
        $variant = isset($_POST['variant']) && is_string($_POST['variant']) ? strip_tags($_POST['variant']) : null;
        $creativity = isset($_POST['creativity']) && is_string($_POST['creativity']) ? strip_tags($_POST['creativity']) : null;
        $level = ['optimal' => '0.8', 'none' => '0', 'low' => '0.2', 'medium' => '0.6', 'high' => '0.8', 'max' => '1'];

        if (empty($templateId)) return null;
        $template = $this->templates($templateId);
        if (empty($template['id'])) return null;
        if (!empty($template['fields'])) {
            foreach (json_decode($template['fields'], true) as $key => $val) {
                $data[$key]['type'] = $val['type'];
                $data[$key]['key'] = $val['key'];
                $data[$key]['label'] = $val['label'];
                $data[$key]['data'] = isset($fields[$val['key']]) ? strip_tags($fields[$val['key']]) : '';
            }
        }

        // check premium template access permission
        $user = $this->userDetails(['id' => $this->uid], 'plan_id, words_generated, words, images');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;
        if (!empty($template['premium']) && empty($plan['premium'])) $this->output(['error' => 'no_access']);

        $this->language = $language;
        $this->tone = $tone;
        $this->data = isset($data) ? $data : null;
        $this->template = isset($template['id']) ? $template['id'] : null;
        $model = !empty($template['model']) ? $template['model'] : 'gpt-4o-mini';
        $temperature = isset($level[$creativity]) && $creativity != 'optimal' ? $level[$creativity] : (!empty($template['temperature']) ? $template['temperature'] : '1');
        $max_tokens = !empty($template['max_tokens']) ? $template['max_tokens'] : 2000;
        $variant = !empty($variant) ? $variant : 1;
        $system = !empty($template['prompt']) ? $template['prompt'] : "You are a helpful assistant.";
        $tone = !empty($tone) ? "\nResponse with $tone tone of voice" : null;
        $lang = !empty($language) ? "\nMust be response in $language language." : null;

        // make fields value
        $requestText = '';
        $trans = [];
        foreach ($fields as $key => $val) {
            $trans["[$key]"] = $val;
            $requestText .= "$val ";
        }

        $blacklists = DB::select('blacklists', 'words', [], 'ORDER by words');
        if ($blacklists) {
            $black_list = null;
            foreach ($blacklists as $val) {
                $black_list .= "$val[words]|";
            }
            if ($black_list) {
                $blacklist = trim($black_list, '|');
                $string = preg_replace('!\s+!', " ", $requestText);
                if (preg_match_all("/\b($blacklist)\b/i", $string, $matches)) exit;
            }
        }

        $getPrompt = DB::select('prompts', 'command', ['template_id' => $templateId], 'ORDER BY id ASC LIMIT 1');
        $prompt = !empty($getPrompt[0]['command']) ? strtr($getPrompt[0]['command'], $trans) : null;
        $messages['system']['role'] = "system";
        $messages['system']['content'] = $system . $lang . $tone;
        $messages['user']['role'] = "user";
        $messages['user']['content'] = $prompt;
        $post['messages'] = array_values($messages);
        $post['model'] = $model;
        $post['temperature'] = (float) $temperature;
        $post['max_tokens'] = (int) $max_tokens;
        $post['n'] = (int) $variant;
        return $this->openai('chat/completions', $post);
    }

    protected function insertHistory($template_id, $text)
    {
        $data['template_id'] = $template_id;
        $data['text'] = $text;
        $data['user_id'] = $this->uid;
        $data['language'] = $this->language;
        $data['tone'] = $this->tone;
        $data['data'] = !empty($this->data) ? json_encode($this->data) : null;
        $data['created'] = date('Y-m-d H:i:s');
        $data['id'] =  md5($this->uid . microtime(true) . rand()) . uniqid();
        DB::insert('history', $data);
    }

    protected function output($arr)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($arr);
        exit;
    }

    protected function getForm($id)
    {
        $user = $this->userDetails(['id' => $this->uid], 'plan_id');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;
        $templateId = array_slice(explode('-', $id), -1)[0];
        $result = DB::select('templates', '*', ['id' => base64_decode($templateId), 'status' => 1], 'LIMIT 1');
        $template = isset($result[0]) ? $result[0] : null;
        $languages = $this->languages();
        $tones = $this->tones();
        ob_start(); ?>
        <?php if (!empty($template['premium']) && empty($plan['premium'])) { ?>
            <div class="alert alert-warning text-center py-2">
                Upgrade your plan to access premium templates.
            </div>
        <?php } ?>
        <div class="row gx-3">
            <?php if (!empty($languages)) { ?>
                <div class="col mb-3">
                    <label class="form-label"><?php echo !empty($template['language_label']) ? $template['language_label'] : 'Language'; ?></label>
                    <select name="language" id="raitor-language" class="form-select">
                        <?php foreach ($languages as $val) { ?>
                            <option value="<?php echo $val['name']; ?>" <?php echo $val['selected'] ? "selected" : (strtolower($val['name']) == 'english' ? "selected" : null); ?>><?php echo $val['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <?php if (!empty($template['tone'])) { ?>
                <?php if (!empty($tones)) { ?>
                    <div class="col mb-3">
                        <label class="form-label"><?php echo !empty($template['tone_label']) ? $template['tone_label'] : 'Tone'; ?></label>
                        <select name="tone" id="raitor-tone" class="form-select">
                            <option value="Default" selected>Default</option>
                            <?php foreach ($tones as $val) { ?>
                                <option value="<?php echo $val['name']; ?>"><?php echo $val['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php if (!empty($template['fields'])) {
            $fields = json_decode($template['fields'], true);
            $field_count = count($fields);
            foreach ($fields as $field) {
                if ($field['type'] == 'select') { ?>
                    <div class="mb-3">
                        <label class="form-label small"><?php echo $field['label']; ?></label>
                        <select name="fields[<?php echo $field['key']; ?>]" class="form-select" required>
                            <?php foreach (!empty($field['placeholder']) ? explode(",", $field['placeholder']) : [] as $val) { ?>
                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } else if ($field['type'] == 'textarea') { ?>
                    <div class="mb-3">
                        <label class="form-label small"><?php echo $field['label']; ?></label>
                        <textarea name="fields[<?php echo $field['key']; ?>]" class="form-control" rows="<?php echo $field_count > 2 ? 5 : 7; ?>" placeholder="<?php echo $field['placeholder']; ?>" required></textarea>
                    </div>
                <?php } else { ?>
                    <div class="mb-3">
                        <label class="form-label small"><?php echo $field['label']; ?></label>
                        <input type="<?php echo $field['type']; ?>" name="fields[<?php echo $field['key']; ?>]" value="" class="form-control" placeholder="<?php echo $field['placeholder']; ?>" required>
                    </div>
        <?php }
            }
        } ?>
        <div class="mb-2">
            <div class="row gx-3">
                <?php if (!empty($template['creativity'])) { ?>
                    <div class="col mb-3"><label class="form-label small"><?php echo !empty($template['creativity_label']) ? $template['creativity_label'] : 'Creativity'; ?></label>
                        <select name="creativity" class="form-select">
                            <option value="optimal">Optimal</option>
                            <option value="none">None (more factual)</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="max">Max (less factual)</option>
                        </select>
                    </div>
                <?php } ?>
                <div class="col mb-3">
                    <label class="form-label small">Results</label>
                    <select id="raitor-variant" name="variant" class="form-select">
                        <option value="1">1 variant</option>
                        <option value="2">2 variants</option>
                        <option value="3">3 variants</option>
                        <option value="4">4 variants</option>
                        <option value="5">5 variants</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-1">
            <button type="submit" class="btn btn-primary fw-semibold w-100" <?php echo (!empty($template['premium']) && empty($plan['premium'])) ? 'disabled' : null; ?>>
                <?php echo !empty($template['button_label']) ? $template['button_label'] : 'Generate'; ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1 d-none d-md-inline" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                </svg>
            </button>
        </div>
<?php die(ob_get_clean());
    }
}
