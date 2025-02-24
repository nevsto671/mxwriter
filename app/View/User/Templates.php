<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
  <?php require_once APP . '/View/User/Head.php'; ?>
</head>

<body>
  <?php require_once APP . '/View/User/Header.php'; ?>
  <main>
    <div class="container-fluid">
      <?php require_once APP . '/View/User/Sidebar.php'; ?>
      <div class="main">
        <?php if (!empty($template)) { ?>
          <div class="row gy-3 g-sm-4">
            <div class="col-12 col-md-4">
              <div class="card p-3 mb-4">
                <div class="mb-1">
                  <div class="d-flex align-content-center">
                    <div class="me-2">
                      <span class="rounded text-white d-flex justify-content-center align-items-center" style="width: 30px; height: 30px; background-color: <?php echo !empty($template['color']) ? $template['color'] : '#f4ac36'; ?>;">
                        <?php if (!empty($template['icon'])) {
                          echo $template['icon'];
                        } else { ?>
                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                            <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                            <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                          </svg>
                        <?php } ?>
                      </span>
                    </div>
                    <h6 class="fw-bold lh-lg mb-2 text-truncate"><?php echo $template['title']; ?></h6>
                  </div>
                </div>
                <?php if ($template['user_id'] == $this->uid && empty($this->plan['my_template'])) { ?>
                  <div class="alert alert-warning text-center py-2">
                    Upgrade your plan to access this templates.
                  </div>
                <?php } else if (!empty($template['premium']) && empty($this->plan['premium'])) { ?>
                  <div class="alert alert-warning text-center py-2">
                    Upgrade your plan to access premium templates.
                  </div>
                <?php } ?>
                <form method="post" class="post-form" id="text-generator">
                  <?php if (!empty($template['language'])) { ?>
                    <div class="row gx-3 mb-3">
                      <?php if (!empty($languages)) { ?>
                        <div class="col">
                          <label class="form-label"><?php echo !empty($template['language_label']) ? $template['language_label'] : 'Language'; ?></label>
                          <select name="language" id="raitor-language" class="form-select">
                            <?php foreach ($languages as $val) { ?>
                              <option value="<?php echo $val['name']; ?>" <?php echo $val['selected'] ? "selected" : (strtolower($val['name']) == 'english' ? "selected" : null); ?>><?php echo $val['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      <?php } ?>
                    </div>
                  <?php } ?>
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
                  </div>
                  <div class="mb-1">
                    <button type="submit" class="btn btn-primary fw-semibold w-100" <?php echo ((!empty($template['premium']) && empty($this->plan['premium'])) || ($template['user_id'] == $this->uid && empty($this->plan['my_template']))) ? 'disabled' : null; ?>>
                      <?php echo !empty($template['button_label']) ? $template['button_label'] : 'Generate'; ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1 d-none d-md-inline" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                      </svg>
                    </button>
                  </div>
                </form>
              </div>
              <?php if (!empty($template['creativity'])) { ?>
                <div class="mb-4 text-center text-muted small">
                  Getting low quality results?<br>Change the creativity or write a better details.
                </div>
              <?php } ?>
            </div>
            <div class="col-12 col-md-8">
              <div class="card bg-transparent border-0 mb-4 shadow-none">
                <div class="card-header bg-white px-3 py-2 mb-3 border-bottom-0 shadow-sm">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="nav nav-underline">
                      <button type="button" class="nav-link text-secondary px-1 <?php echo isset($_GET['page']) ? null : 'active'; ?>" data-bs-toggle="tab" data-bs-target="#result-tab-pane" aria-selected="<?php echo isset($_GET['page']) ? 'false' : 'true'; ?>">New</button>
                      <button type="button" class="nav-link text-secondary px-1 <?php echo isset($_GET['page']) ? 'active' : null; ?>" data-bs-toggle="tab" data-bs-target="#history-tab-pane" aria-selected="<?php echo isset($_GET['page']) ? 'true' : 'false'; ?>">History</button>
                    </div>
                    <div>
                    </div>
                  </div>
                </div>
                <div class="tab-content">
                  <div class="tab-pane <?php echo isset($_GET['page']) ? null : 'show active'; ?>" id="result-tab-pane">
                    <div class="text-center py-5 px-lg-5" id="result-info">
                      <h5 class="fw-bold mb-4 text-muted"><?php echo $template['title']; ?></h5>
                      <p class="text-muted"><?php echo $template['description']; ?></p>
                      <div class="text-muted mb-4">
                        <?php echo !empty($template['help_text']) ? $template['help_text'] : 'Generate results by filling up the form on the left and clicking on "Generate".'; ?>
                      </div>
                      <?php if (empty($template['help_text'])) { ?>
                        <p class="text-muted">Your copies created by artificial intelligence will appear here.</p>
                      <?php } ?>
                    </div>
                    <div class="text-center py-5" id="result-error" style="display: none;">
                      <div class="mb-3 mx-auto text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                          <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                        </svg>
                      </div>
                      <h5 class="fw-bold mb-4 text-muted">Generation Failed</h5>
                      <p class="text-muted" id="error-message">Something went wrong, please try again.</p>
                    </div>
                    <div class="text-center py-5" id="no-credits" style="display: none;">
                      <div class="mb-3 mx-auto text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                          <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                        </svg>
                      </div>
                      <h5 class="fw-bold mb-4 text-muted">Insufficient Credits</h5>
                      <p class="text-muted">You don't have enough credits to generate more content. Please consider upgrading your account for more credits.</p>
                      <a class="btn btn-primary fw-semibold" href="<?php echo $this->url('my/plans'); ?>">Upgrade account</a>
                    </div>
                    <div class="modal fade" id="no-credits-modal" tabindex="-1" aria-labelledby="nocredits" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body text-center py-4">
                            <div class="mb-4 mx-auto text-primary">
                              <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                              </svg>
                            </div>
                            <h3 class="fw-bold mb-3">Insufficient Credits</h3>
                            <p class="text-muted fw-semibold fs-6 mb-4">Sorry, you have exhausted your credits to generate more content. Please upgrade your account.</p>
                            <button type="button" class="btn btn-lg btn-primary fw-bold px-4 me-3" data-bs-dismiss="modal" aria-label="Close">Got it</button><a class="btn btn-success fw-semibold" href="<?php echo $this->url('my/plans'); ?>">Upgrade</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="result-error-modal" tabindex="-1" aria-labelledby="resulterror" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body text-center py-4">
                            <div class="mb-4 mx-auto text-danger">
                              <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                              </svg>
                            </div>
                            <h3 class="fw-bold mb-3">Generation Failed</h3>
                            <p class="text-muted fw-semibold fs-6 mb-4 error-message">Something went wrong, please try again.</p>
                            <button type="button" class="btn btn-lg btn-primary fw-bold px-4" data-bs-dismiss="modal" aria-label="Close">OK</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="input-required-modal" tabindex="-1" aria-labelledby="addmoretext" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body text-center py-4">
                            <div class="mb-4 mx-auto text-danger">
                              <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                              </svg>
                            </div>
                            <h3 class="fw-bold mb-3">Missing inputs</h3>
                            <p class="text-muted fw-semibold fs-6 mb-4">Please fill out all the inputs to generate content.</p>
                            <button type="button" class="btn btn-lg btn-primary fw-bold px-4" data-bs-dismiss="modal" aria-label="Close">OK</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="results"></div>
                    <div id="response" style="display: none;">
                      <div class="card px-3 py-2 pb-4 mb-3 response-message">
                        <div class="flex-grow-1">
                          <div class="d-flex justify-content-between">
                            <div></div>
                            <div class="btn-group clipboard">
                              <button type="button" class="btn btn-sm btn-clipboard border-0" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy to clipboard" data-copied-title="Copied!">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-clipboard" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path>
                                  <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check2" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                              </button>
                              <button type="button" class="btn btn-sm border-0 delete-history" title="" data-id="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M4 7l16 0"></path>
                                  <path d="M10 11l0 6"></path>
                                  <path d="M14 11l0 6"></path>
                                  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                              </button>
                            </div>
                          </div>
                          <div class="markdown ai-content notranslate"></div>
                          <span class="result-thinking"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane <?php echo isset($_GET['page']) ? 'show active' : null; ?>" id="history-tab-pane">
                    <?php if (!empty($histories)) { ?>
                      <?php foreach ($histories as $val) { ?>
                        <div class="card px-3 py-2 pb-4 mb-3">
                          <div class="d-flex justify-content-between">
                            <div></div>
                            <div class="btn-group clipboard">
                              <button type="button" class="btn btn-sm border-0 btn-clipboard" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy to clipboard" data-copied-title="Copied!">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-clipboard" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path>
                                  <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check2" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                              </button>
                              <button type="button" class="btn btn-sm border-0 delete-history" title="" data-id="<?php echo $val['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M4 7l16 0"></path>
                                  <path d="M10 11l0 6"></path>
                                  <path d="M14 11l0 6"></path>
                                  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                              </button>
                            </div>
                          </div>
                          <div class="markdown ai-content notranslate"><?php echo !empty($val['text']) ? htmlspecialchars($val['text']) : 'Not available'; ?></div>
                        </div>
                      <?php } ?>
                      <nav class="my-4"><?php echo $pagination; ?></nav>
                    <?php  } else { ?>
                      <div class="text-center text-muted my-5">
                        <div class="mb-3 mx-auto" style="width: 36px;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                            <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                          </svg>
                        </div>
                        <h5 class="fw-bold mb-4 text-muted">History not available!</h5>
                        <div class="text-muted">
                          Generate results by filling up the form on the left and clicking on "Generate".
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } else { ?>
          <div class="mb-4">
            <div class="position-relative">
              <span class="position-absolute p-3 start-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#999" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                  <path d="M21 21l-6 -6"></path>
                </svg>
              </span>
              <input type="text" class="form-control form-control-lg py-3 fs-6" id="search-template" style="border-radius: 1rem; padding-left: 3rem;" value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search'] : null; ?>" placeholder="What do you want to write?">
            </div>
          </div>
          <div class="mb-3">
            <div class="nav d-block text-nowrap pb-3" id="template-group" data-simplebar>
              <button type="button" class="nav-link fw-semibold px-1 me-3 d-inline-block active" data-bs-toggle="tab" data-bs-target="all">All</button>
              <?php foreach ($template_group as $template) { ?>
                <button type="button" class="nav-link fw-semibold px-1 me-3 d-inline-block" data-bs-toggle="tab" data-bs-target="tmp_<?php echo md5($template['group_name']); ?>"><?php echo $template['group_name']; ?></button>
              <?php } ?>
            </div>
          </div>
          <div class="row g-4" id="tab-content">
            <?php foreach ($templates as $template) { ?>
              <div class="col-12 col-sm-6 col-lg-4 col-xl-3" data-category="tmp_<?php echo md5($template['group_name']); ?>">
                <a class="card p-3 text-decoration-none h-100" href="<?php echo $this->url("my/templates/$template[slug]-" . base64_encode($template['id'])); ?>">
                  <div class="d-flex justify-content-between mb-3">
                    <div>
                      <span class="rounded text-white mt-1 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px; background-color: <?php echo !empty($template['color']) ? $template['color'] : '#f4ac36'; ?>;">
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
                    <div>
                      <?php if (!empty($template['premium'])) { ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sparkles" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#eb9234" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M16 18a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm0 -12a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm-7 12a6 6 0 0 1 6 -6a6 6 0 0 1 -6 -6a6 6 0 0 1 -6 6a6 6 0 0 1 6 6z" />
                        </svg>
                      <?php } else { ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#bbb" class="bi bi-arrow-up-right" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0v-6z" />
                        </svg>
                      <?php } ?>
                    </div>
                  </div>
                  <h6 class="fw-bold text-truncate"><?php echo $template['title']; ?></h6>
                  <p class="text-muted mb-0"><?php echo $template['description']; ?></p>
                </a>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </main>
  <?php require_once APP . '/View/User/Tail.php'; ?>
  <script>
    const clipboard = new ClipboardJS(".btn-clipboard", {
      target: e => e.closest(".card").querySelector(".ai-content"),
      text: e => e.closest(".card").querySelector(".ai-content")
    });
    clipboard.on('success', function(e) {
      var btn = $(e.trigger);
      var tooltip = bootstrap.Tooltip.getInstance(e.trigger);
      tooltip.setContent({
        '.tooltip-inner': btn.attr('data-copied-title')
      });
      document.getSelection().removeAllRanges();
      btn.find('.bi-clipboard').hide();
      btn.find('.bi-check2').show();
      setTimeout(function() {
        btn.find('.bi-check2').hide();
        btn.find('.bi-clipboard').show();
        tooltip.hide();
        tooltip.setContent({
          '.tooltip-inner': btn.attr('data-bs-title')
        });
      }, 3000);
    });
    clipboard.on('error', function(e) {
      var btn = $(e.trigger);
      const tooltip = bootstrap.Tooltip.getInstance(e.trigger);
      tooltip.setContent({
        '.tooltip-inner': 'Not copied!'
      });
    });
  </script>
</body>

</html>