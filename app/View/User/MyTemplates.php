<!doctype html>
<html lang="<?php echo $this->setting['direction'] == 'rtl' ? 'ar' : 'en'; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
    <?php require_once APP . '/View/User/Head.php'; ?>
</head>

<body>
    <?php require_once APP . '/View/Admin/Header.php'; ?>
    <main>
        <div class="container-fluid">
            <?php require_once APP . '/View/Admin/Sidebar.php'; ?>
            <div class="main">
                <?php if (isset($_GET['create']) || !empty($template)) { ?>
                    <div class="row justify-content-center justify-content-xl-start mb-5">
                        <div class="col-12 col-xxl-11 offset-xxl-1" style="max-width: 1065px;">
                            <?php if ($flash = $this->flash()) { ?>
                                <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                            <?php } ?>
                            <div class="card border-0 p-3">
                                <?php if (empty($template)) { ?>
                                    <h5 class="fw-bold mb-4">Add new template</h5>
                                <?php } else { ?>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold mb-4">Update template</h5>
                                        <div>
                                            <a class="btn btn-sm border-0" href="<?php echo $this->url("my/templates/$template[slug]-" . base64_encode($template['id'])); ?>?preview" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Preview">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </a>
                                            <a class="btn btn-sm border-0" href="<?php echo $this->url('my/templates/list?id=' . $template['id'] . '&duplicate=' . md5($template['id'])) ?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create duplicate">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                    <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                                <form method="post" class="form post-form" novalidate>
                                    <div class="mb-4">
                                        <label for="input-type" class="form-label small">GPT Model</label>
                                        <select name="model" class="form-select notranslate" required>
                                            <?php foreach ($models ?: [] as $val) { ?>
                                                <option value="<?php echo $val['id']; ?>" <?php echo isset($template['model']) && $template['model'] == $val['id'] ? "selected" : (!isset($template['model']) && isset($chat_model) && $chat_model == $val['model'] ? "selected" : null); ?>><?php echo $val['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row g-3 mb-4">
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label small">Title (Use case)</label>
                                            <input type="text" name="title" class="form-control" minlength="2" placeholder="e.g. Article generate" value="<?php echo isset($template['title']) ? $template['title'] : null; ?>" required>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label small">Group name (category)</label>
                                            <input type="text" name="group_name" class="form-control" minlength="2" maxlength="50" placeholder="e.g. Blog Tools" value="<?php echo isset($template['group_name']) ? $template['group_name'] : null; ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label small">Description</label>
                                        <textarea name="description" class="form-control autosize" rows="4" minlength="2" maxlength="500" placeholder="Please write about the template" required><?php echo isset($template['description']) ? $template['description'] : null; ?></textarea>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label small">Instructions (optional)</label>
                                        <textarea name="system_prompt" class="form-control autosize" rows="10" placeholder="Train your ai how to act and response. e.g. You are a helpful assistant with expertise in story writing. Your goal is to generate a well-researched and engaging story on a given topic."><?php echo isset($template['prompt']) ? $template['prompt'] : null; ?></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="d-flex">
                                                <h6 class="fw-semibold my-2">Add field to get data from user</h6>
                                                <button type="button" class="btn btn-link small text-decoration-none p-1 ms-2 fw-semibold" id="addField">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg> Add Field
                                                </button>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div id="fieldResult">
                                            <?php if (!empty($template['fields'])) { ?>
                                                <?php foreach (json_decode($template['fields'], true) as $index => $field) { ?>
                                                    <div class="row g-2 mb-3 fieldArea">
                                                        <div class="col-12 col-sm-7">
                                                            <div class="d-flex">
                                                                <select name="fields[type][]" class="form-select me-2 fieldType" style="width: 210px;" required>
                                                                    <option value="input" <?php echo isset($field['type']) && $field['type'] == 'input' ? "selected" : null; ?>>Single line</option>
                                                                    <option value="textarea" <?php echo isset($field['type']) && $field['type'] == 'textarea' ? "selected" : null; ?>>Multi line</option>
                                                                    <option value="select" <?php echo isset($field['type']) && $field['type'] == 'select' ? "selected" : null; ?>>Select list</option>
                                                                </select>
                                                                <input type="text" class="form-control fieldKey me-2" name="fields[key][]" minlength="3" placeholder="field key" style="width: 150px;" value="<?php echo isset($field['key']) ? $field['key'] : null; ?>" required>
                                                                <input type="text" class="form-control w-100 fieldLabel" name="fields[label][]" value="<?php echo isset($field['label']) ? $field['label'] : null; ?>" placeholder="Enter field label" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-5">
                                                            <div class="d-flex">
                                                                <input type="text" name="fields[placeholder][]" class="form-control w-100 fieldPlaceholder" value="<?php echo isset($field['placeholder']) ? $field['placeholder'] : null; ?>" placeholder="Enter field placeholder" data-placeholder="Enter field placeholder" data-select-placeholder="Enter comma-separated options">
                                                                <button type="button" class="btn btn-light ms-2 addToField" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to prompt">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M12 5l0 14" />
                                                                        <path d="M5 12l14 0" />
                                                                    </svg>
                                                                </button>
                                                                <button type="button" class="btn btn-light ms-2 removeField" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove field">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M4 7l16 0" />
                                                                        <path d="M10 11l0 6" />
                                                                        <path d="M14 11l0 6" />
                                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } else if (empty($template)) { ?>
                                                <div class="row g-2 mb-3 fieldArea">
                                                    <div class="col-12 col-sm-7">
                                                        <div class="d-flex">
                                                            <select name="fields[type][]" class="form-select me-2 fieldType" style="width: 210px;" required>
                                                                <option value="input">Single line</option>
                                                                <option value="textarea">Multi line</option>
                                                                <option value="select">Select list</option>
                                                            </select>
                                                            <input type="text" class="form-control fieldKey me-2" name="fields[key][]" value="field1" minlength="3" placeholder="field key" style="width: 150px;">
                                                            <input type="text" name="fields[label][]" class="form-control w-100 fieldLabel" placeholder="Enter field label">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-5">
                                                        <div class="d-flex">
                                                            <input type="text" name="fields[placeholder][]" class="form-control w-100 fieldPlaceholder" placeholder="Enter field placeholder" data-placeholder="Enter field placeholder" data-select-placeholder="Enter comma-separated options">
                                                            <button type="button" class="btn btn-light ms-2 addToField" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to prompt">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M12 5l0 14" />
                                                                    <path d="M5 12l14 0" />
                                                                </svg>
                                                            </button>
                                                            <button type="button" class="btn btn-light ms-2 removeField" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove field">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($prompts)) { ?>
                                        <div class="mb-5" id="prompt">
                                            <label class="form-label small d-flex justify-content-between">
                                                Prompt <a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#prompt_help">Help?</a>
                                            </label>
                                            <?php foreach ($prompts as $index => $val) { ?>
                                                <?php if (count($prompts) > 1) echo ('<div class="my-2">#' . ($index + 1) . '</div>'); ?>
                                                <textarea name="prompt[]" class="form-control userPrompt autosize" rows="10" minlength="3" placeholder="Describe your action. e.g. Write a story following the topic: [field1]" required><?php echo $val['command']; ?></textarea>
                                            <?php } ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="mb-5" id="prompt">
                                            <label class="form-label small d-flex justify-content-between">
                                                Prompt <a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#prompt_help">Help?</a>
                                            </label>
                                            <textarea name="prompt[]" class="form-control userPrompt autosize" rows="10" minlength="3" placeholder="Describe your action. e.g. Write a story following the topic: [field1]" required></textarea>
                                        </div>
                                    <?php } ?>
                                    <div class="mb-5">
                                        <h6 class="fw-bold mb-3">Knowledge</h6>
                                        <div class="mb-4" id="fileHistory">
                                            <div class="row g-3" id="fileList">
                                                <?php foreach (!empty($files) ? $files : [] as $val) {
                                                    $extension = pathinfo($val['name'], PATHINFO_EXTENSION); ?>
                                                    <div class="col-12 col-md-6 col-xxl-4" id="<?php echo $val['id']; ?>">
                                                        <div class="card p-2 border">
                                                            <div class="d-flex">
                                                                <div>
                                                                    <div class="rounded text-white mt-1 d-flex justify-content-center align-items-center" style="width: 44px; height: 44px; background-color: #fc5d92;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                                            <path d="M9 9l1 0" />
                                                                            <path d="M9 13l6 0" />
                                                                            <path d="M9 17l6 0" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between ms-2 w-100 text-truncate">
                                                                    <div class="text-truncate">
                                                                        <div class="fw-bold text-truncate pt-1 mb-1"><?php echo htmlspecialchars($val['name']); ?></div>
                                                                        <div class="text-muted small text-uppercase fileExtension"><?php echo !empty($extension) ? $extension : null; ?></div>
                                                                    </div>
                                                                    <div class="pt-2 ms-2 delete-button" style="display: none;">
                                                                        <button type="button" class="dropdown-item m-0 d-flex align-items-center deleteFile" data-id="<?php echo $val['id']; ?>" data-bs-toggle="modal" data-bs-target="#deleteFile">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                <path d="M4 7l16 0" />
                                                                                <path d="M10 11l0 6" />
                                                                                <path d="M14 11l0 6" />
                                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-12 col-md-6 col-xxl-4" id="fileItem" style="display: none;">
                                                    <div class="card p-2 border">
                                                        <div class="d-flex">
                                                            <div>
                                                                <div class="rounded text-white mt-1 d-flex justify-content-center align-items-center" style="width: 44px; height: 44px; background-color: #fc5d92;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                                        <path d="M9 9l1 0" />
                                                                        <path d="M9 13l6 0" />
                                                                        <path d="M9 17l6 0" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-between ms-2 w-100 text-truncate">
                                                                <div class="text-truncate">
                                                                    <div class="fw-bold text-truncate pt-1 mb-1 fileName"></div>
                                                                    <div class="text-muted small text-uppercase fileExtension"></div>
                                                                </div>
                                                                <div class="pt-2 ms-2 delete-button" style="display: none;">
                                                                    <button type="button" class="dropdown-item m-0 d-flex align-items-center deleteFile" data-id="" data-bs-toggle="modal" data-bs-target="#deleteFile">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M4 7l16 0" />
                                                                            <path d="M10 11l0 6" />
                                                                            <path d="M14 11l0 6" />
                                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="deleteFile" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm z-3">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5">Remove file</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="mt-3 mb-4 text-center">Are you sure you want to remove this file?</h6>
                                                            <div class="py-2">
                                                                <button type="button" class="btn btn-danger w-100" id="fileDeleteId" data-bs-dismiss="modal" data-loader="">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="uploadError" class="alert alert-danger py-2 mb-4" style="display: none;">Something went wrong. Please try again.</div>
                                            <div id="UploadProgress" class="progress mb-3" style="display: none;">
                                                <div id="progressBar" class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            </div>
                                            <button type="button" id="fileUploadButton" class="btn border" aria-label="file">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                    <path fill="currentColor" fill-rule="evenodd" d="M9 7a5 5 0 0 1 10 0v8a7 7 0 1 1-14 0V9a1 1 0 0 1 2 0v6a5 5 0 0 0 10 0V7a3 3 0 1 0-6 0v8a1 1 0 1 0 2 0V9a1 1 0 1 1 2 0v6a3 3 0 1 1-6 0z" clip-rule="evenodd"></path>
                                                </svg><span class="ms-2">Upload files</span>
                                            </button>
                                            <input type="file" id="fileUpload" name="files" style="display: none" accept=".c,.cs,.cpp,.doc,.docx,.html,.htm,.java,.json,.md,.pdf,.php,.pptx,.py,.py,.rb,.tex,.txt,.css,.js,.sh,.ts" multiple>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-link fw-bold text-decoration-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdvance" aria-expanded="false" aria-controls="collapseAdvance">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg> Advance setup
                                        </button>
                                    </div>
                                    <div class="mb-5 collapse" id="collapseAdvance">
                                        <div class="row g-3 mb-4">
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label small">Maximum tokens output (optional)</label>
                                                <input type="text" name="max_tokens" class="form-control" placeholder="e.g. 2500" value="<?php echo isset($template['max_tokens']) ? $template['max_tokens'] : null; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                                <div class="small text-muted mt-1">Enter between 100 to 4000 based on model token support, 1k token = 750 words maximum generate ability.</div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label small">Temperature creativity level (optional)</label>
                                                <input type="text" name="temperature" class="form-control" placeholder="e.g. 0.8" value="<?php echo isset($template['temperature']) ? $template['temperature'] : null; ?>" maxlength="3" onkeypress="return /[0-9.]/i.test(event.key)">
                                                <div class="small text-muted mt-1">Enter between 0 to 2. Higher number will make the output more random, lower mumber will make it more focused and deterministic.</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label small">Generate button label (optional)</label>
                                                <input type="text" name="button_label" class="form-control" minlength="2" maxlength="200" placeholder="e.g. Generate" value="<?php echo isset($template['button_label']) ? $template['button_label'] : null; ?>">
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label small">Language label (optional)</label>
                                                <input type="text" name="language_label" class="form-control" minlength="2" maxlength="100" placeholder="e.g. Language" value="<?php echo isset($template['language_label']) ? $template['language_label'] : null; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label small">Creativity label (optional)</label>
                                                <input type="text" name="creativity_label" class="form-control" minlength="2" maxlength="180" placeholder="e.g. Creativity" value="<?php echo isset($template['creativity_label']) ? $template['creativity_label'] : null; ?>">
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label small">Tone label (optional)</label>
                                                <input type="text" name="tone_label" class="form-control" minlength="2" maxlength="180" placeholder="e.g. Tone" value="<?php echo isset($template['tone_label']) ? $template['tone_label'] : null; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="colorInput" class="form-label">Help text (optional)</label>
                                            <textarea name="help_text" class="form-control autosize" rows="4" placeholder="e.g. Generate results by filling up the form on the left and clicking on 'Generate'."><?php echo !empty($template['help_text']) ? $template['help_text'] : null; ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="colorInput" class="form-label">Background color for icon (optional)</label>
                                            <div class="input-group">
                                                <span class="input-group-text p-0" id="input-group-color">
                                                    <input type="color" name="colorInput" class="form-control form-control-color border-0 p-1" id="colorInput" style="width: 100px;" value="<?php echo isset($template['color']) ? $template['color'] : '#281f56'; ?>">
                                                </span>
                                                <input type="text" class="form-control" name="color" value="<?php echo isset($template['color']) ? $template['color'] : '#281f56'; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="colorInput" class="form-label">Svg icon 24x24 (optional) <a class="text-decoration-none" href="https://tabler.io/icons" target="_blank">Get icon</a></label>
                                            <textarea name="icon" class="form-control" rows="6"><?php echo !empty($template['icon']) ? $template['icon'] : null; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-4 flex-row-reverse">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="creativity" class="form-check-input" id="input-creativity" <?php echo isset($template['creativity']) ? ($template['creativity'] == 1 ? 'checked' : null) : 'checked'; ?>>
                                                <label class="form-check-label" for="input-creativity">Creativity select option</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="tone" class="form-check-input" id="input-tone" <?php echo isset($template['tone']) ? ($template['tone'] == 1 ? 'checked' : null) : 'checked'; ?>>
                                                <label class="form-check-label" for="input-tone">Tone select option</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="status" class="form-check-input" id="input-status" <?php echo isset($template['status']) ? ($template['status'] == 1 ? 'checked' : null) : 'checked'; ?>>
                                                <label class="form-check-label" for="input-status">Active and Publish</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="language" class="form-check-input" id="input-language" <?php echo isset($template['language']) ? ($template['language'] == 1 ? 'checked' : null) : 'checked'; ?>>
                                                <label class="form-check-label" for="input-language">Language select option</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button type="submit" class="btn btn-primary px-4" id="submitButton" data-loader="Saving...">Save details</button>
                                        </div>
                                        <div>
                                            <?php if (!empty($template)) { ?>
                                                <button type="button" class="btn btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                                <div id="fields" style="display: none;">
                                    <div class="row g-2 mb-3 fieldArea">
                                        <div class="col-12 col-sm-7">
                                            <div class="d-flex">
                                                <select name="fields[type][]" class="form-select me-2 fieldType" style="width: 210px;" required>
                                                    <option value="input">Single line</option>
                                                    <option value="textarea">Multi line</option>
                                                    <option value="select">Select list</option>
                                                </select>
                                                <input type="text" class="form-control fieldKey me-2" name="fields[key][]" minlength="3" placeholder="field key" style="width: 150px;" required>
                                                <input type="text" name="fields[label][]" class="form-control w-100 fieldLabel" placeholder="Enter field label" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-5">
                                            <div class="d-flex">
                                                <input type="text" name="fields[placeholder][]" class="form-control w-100 fieldPlaceholder" placeholder="Enter field placeholder" data-placeholder="Enter field placeholder" data-select-placeholder="Enter comma-separated options">
                                                <button type="button" class="btn btn-light ms-2 addToField" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to prompt">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg>
                                                </button>
                                                <button type="button" class="btn btn-light ms-2 removeField" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove field">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="delete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered z-3">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Delete</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" class="form" novalidate>
                                                    <h6 class="mt-3 mb-4 text-center">Are you sure you want to delete this template?</h6>
                                                    <div class="py-2">
                                                        <input type="hidden" name="delete_template" value="<?php echo !empty($template['id']) ? md5($template['id']) : null; ?>">
                                                        <button type="submit" class="btn btn-danger w-100" data-loader="Deleting...">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="prompt_help" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Prompt example</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>If you want to get data from user then need to add input fields. Field key must be in a square bracket. Such as [field1], [field2], [product_name] etc. You can add field key by click on + button or copy paste with square bracket.</p>
                                                <p>Suppose you want to get product name and brand name from user. So need to add two field like field1 and field2. Now your prompt is: Write a product description about [field1] and following the brand [field2].</p>
                                                <p>When user fill product name input box by <b>Wireless Keyboard</b> and brand name input box by <b>Logitech, HP</b> then system convert it to prompt below.</p>
                                                <p>Write a product description about Wireless Keyboard and following the brand Logitech, HP.</p>
                                                <p>
                                                    Example:<br>
                                                    Write a story about [field_key]<br>
                                                    Create a blog outline following my topic [field1] and keywords [field2]
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold mb-4">My Templates</h2>
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="input-group border rounded">
                                        <input type="text" name="search" id="search" class="form-control border-0 shadow-none" value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search'] : null; ?>" placeholder="Search template">
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-primary <?php echo empty($template_access) ? "disabled" : null; ?>" href="<?php echo $this->url("my/templates/list?create"); ?>">Add template</a>
                                </div>
                            </div>
                        </div>
                        <?php if ($flash = $this->flash()) { ?>
                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                        <?php } ?>
                        <?php if (empty($this->plan['my_template'])) { ?>
                            <div class="alert alert-warning text-center">To access this feature, please upgrade your current plan.</div>
                        <?php } else if (empty($template_access)) { ?>
                            <div class="alert alert-warning text-center">You have exhausted your template creation credits. Please upgrade your plan to create more templates.</div>
                        <?php } ?>
                        <?php if ($group_templates) { ?>
                            <div class="accordion" id="accordionTemplate">
                                <?php foreach ($group_templates as $key => $templates) { ?>
                                    <div class="accordion-item mb-3">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed shadow-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo md5($key); ?>" aria-expanded="false" aria-controls="collapse_<?php echo md5($key); ?>">
                                                <?php echo $key; ?>
                                            </button>
                                        </div>
                                        <div id="collapse_<?php echo md5($key); ?>" class="accordion-collapse collapse" data-bs-parent="#accordionTemplate">
                                            <div class="table-responsive p-2">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Use case</th>
                                                            <th scope="col" class="d-none d-md-table-cell text-end">Model</th>
                                                            <th scope="col" class="d-none d-sm-table-cell text-end" style="width: 60px">Token</th>
                                                            <th scope="col" class="d-none d-sm-table-cell text-end" style="width: 60px">Status</th>
                                                            <th scope="col" class="text-end" style="width: 40px">Edit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($templates as $template) { ?>
                                                            <tr class="templateRow">
                                                                <td>
                                                                    <div class="d-flex my-1">
                                                                        <div>
                                                                            <span class="rounded text-white d-flex justify-content-center align-items-center" style="width: 30px; height: 30px; background-color: <?php echo $template['color']; ?>;">
                                                                                <?php if (!empty($template['icon'])) {
                                                                                    echo $template['icon'];
                                                                                } else { ?>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                                                                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                                                                                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                                                                    </svg>
                                                                                <?php } ?>
                                                                            </span>
                                                                        </div>
                                                                        <div class="ms-3">
                                                                            <span class="fw-semibold templateTitle"><?php echo $template['title']; ?></span><?php echo $template['premium'] ? '<span class="badge text-bg-warning ms-2">Premium</span>' : null; ?>
                                                                            <div class="text-muted small">
                                                                                <?php echo $template['description']; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="d-none d-md-table-cell text-end notranslate"><?php echo !empty($template['model_name']) ? $template['model_name'] : '<span class="text-danger">Unknown</span>'; ?></td>
                                                                <td class="d-none d-sm-table-cell text-end"><?php echo $template['max_tokens']; ?></td>
                                                                <td class="d-none d-sm-table-cell text-end status"><?php echo $template['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                                                <td class="text-end"><a class="text-decoration-none" href="<?php echo $this->url("my/templates/list?id=$template[id]"); ?>">Edit</a></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="my-3">Total templates: <?php echo $total; ?></div>
                        <?php } else { ?>
                            <div>You have not added any template yet.</div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
    <script>
        $(document).ready(function() {
            $("#search").on("input", function() {
                var value = $(this).val().toLowerCase();
                if (value.length >= 2) {
                    $(".templateTitle").each(function(index) {
                        var accordionItem = $(this).closest('.accordion-item');
                        var tableRow = $(this).closest('.templateRow');
                        if ($(this).text().toLowerCase().indexOf(value) > -1) {
                            accordionItem.find('.accordion-collapse').collapse('show');
                            tableRow.show();
                        } else {
                            if (index === 0) {
                                accordionItem.find('.accordion-collapse').collapse('hide');
                            }
                            tableRow.hide();
                        }
                    });
                } else {
                    $(".accordion-collapse").collapse('hide');
                    $('.templateRow').show();
                }
            });

            $(".accordion-item").click(function() {
                $(this).find('.templateRow').show();
            });

            $("#colorInput").on('input', function() {
                $("input[name=color]").val($(this).val());
            });

            $("#addField").click(function() {
                let clonedFieldArea = $('#fields .fieldArea').clone();
                clonedFieldArea.appendTo("#fieldResult").show();
                let fieldKeys = $('#fieldResult .fieldArea .fieldKey').map(function() {
                    return $(this).val();
                }).get();
                let fieldCount = 1;
                let fieldKey = `field${fieldCount}`;
                while (fieldKeys.includes(fieldKey)) {
                    fieldCount++;
                    fieldKey = `field${fieldCount}`;
                }
                clonedFieldArea.find('.fieldKey').val(fieldKey);
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            });

            $(document).on("change", ".fieldType", function(e) {
                var p = $(this).closest('.fieldArea').find('.fieldPlaceholder');
                if ($(this).val() == 'select') {
                    p.attr('placeholder', p.data('select-placeholder'));
                } else {
                    p.attr('placeholder', p.data('placeholder'));
                }
            });

            $(document).on("click", ".removeField", function(e) {
                $('[data-bs-toggle="tooltip"]').tooltip('hide');
                if (confirm("Are you sure you want to remove this field?")) {
                    $(this).parents('.fieldArea').remove();
                }
            });

            $(document).on("click", ".addToField", function(e) {
                var textarea = $(".userPrompt")[0];
                var cursorPosition = textarea.selectionStart;
                var currentValue = textarea.value;
                var str = $(this).parents('.fieldArea').find('.fieldLabel').val().trim();
                var keyText = $(this).parents('.fieldArea').find('.fieldKey').val();
                var newValue = currentValue.substring(0, cursorPosition) + "[" + keyText + "]" + currentValue.substring(cursorPosition);
                textarea.value = newValue;
            });

            $(document).on("input", ".fieldKey", function(e) {
                $(this).val($(this).val().replace(/ /g, '_'));
                $(this).val($(this).val().replace(/_+/g, '_'));
            });

            $('#fileUpload').change(function() {
                var files = this.files;
                if (files.length > 0) {
                    var formData = new FormData();
                    for (var i = 0; i < files.length; i++) {
                        formData.append('files[]', files[i]);
                    }
                    $('#uploadError').hide();
                    $('#UploadProgress').show();
                    $('#UploadLoader').show();
                    $('#fileHistory').show();
                    $('#fileUploadButton').prop('disabled', true);
                    $('#submitButton').prop('disabled', true);
                    $.ajax({
                        url: '',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    percentComplete = Math.min(Math.round(percentComplete), 99);
                                    $('#progressBar').width(percentComplete + '%');
                                    $('#progressBar').html(percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(response) {
                            if (response && typeof response === 'object') {
                                if (response.files && Array.isArray(response.files)) {
                                    response.files.forEach(function(file) {
                                        var newItem = $('#fileItem').clone().show();
                                        newItem.find('.fileName').text(file.fileName);
                                        newItem.find('.fileExtension').text(file.fileExtension);
                                        newItem.find('.deleteFile').attr('data-id', file.fileId);
                                        newItem.attr('id', file.fileId);
                                        $('#fileItem').before(newItem);
                                    });

                                } else if (response.error) {
                                    $('#uploadError').html(response.error).show();
                                }
                                $('#fileUploadButton').show();
                                $('#UploadLoader').hide();
                                $('#UploadProgress').hide();
                                $('#progressBar').width('0%');
                                $('#progressBar').html('');
                            } else {
                                $('#uploadError').show();
                                $('#fileUploadButton').show();
                                $('#UploadProgress').hide();
                                $('#UploadLoader').hide();
                            }
                        },
                        complete: function() {
                            $('#fileUploadButton').val('');
                            $('#fileUploadButton').prop('disabled', false);
                            $('#submitButton').prop('disabled', false);
                        },
                        error: function() {
                            $('#uploadError').show();
                            $('#fileUploadButton').show();
                            $('#UploadProgress').hide();
                            $('#UploadLoader').hide();
                            $('#submitButton').prop('disabled', false);
                        }
                    });
                }
            });

            $('#fileUploadButton').click(function() {
                $('#fileUpload').click();
            });

            $(document).on("click", ".deleteFile", function(e) {
                var id = $(this).data('id');
                $('#fileDeleteId').attr('data-id', id);
            });

            $(document).on("click", "#fileDeleteId", function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $('#' + id).hide();
                $.post("", {
                    delete_file_id: id
                });
            });
        });
    </script>
</body>

</html>