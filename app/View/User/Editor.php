<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
  <?php require_once APP . '/View/User/Head.php'; ?>
</head>

<body class="editor">
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top px-1">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <ul class="nav d-flex align-items-center">
          <li class="nav-item d-flex me-3">
            <?php if ($this->setting['site_logo_light']) { ?>
              <a href="<?php echo $this->url(null); ?>">
                <img class="site-logo" src="<?php echo $this->url($this->setting['site_logo_light']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
              </a>
            <?php } else { ?>
              <a class="navbar-brand" href="<?php echo $this->url(null); ?>"><?php echo $this->setting['site_name']; ?></a>
            <?php } ?>
          </li>
          <li class="nav-item d-none d-md-inline">
            <a class="nav-link d-flex align-items-center" href="<?php echo $this->url('my/documents'); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                <path d="M9 17h6" />
                <path d="M9 13h6" />
              </svg><span class="ms-1 d-none d-md-inline">Documents</span>
            </a>
          </li>
          <li class="nav-item d-none d-md-inline">
            <a class="nav-link d-flex align-items-center" href="<?php echo $this->url('my/history'); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-history" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 8l0 4l2 2" />
                <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
              </svg><span class="ms-1 d-none d-md-inline">History</span>
            </a>
          </li>
        </ul>
        <ul class="nav d-flex align-items-center">
          <li class="nav-item">
            <button type="button" class="nav-link btn d-flex align-items-center" data-bs-toggle="<?php echo $doc_id ? "save" : "modal"; ?>" data-bs-target="#save-as" data-doc="<?php echo $doc_id; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M14 4l0 4l-6 0l0 -4" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 12l5 5l10 -10" />
              </svg>
              <span class="ms-1 d-none d-sm-inline">Save</span>
            </button>
          </li>
          <li class="nav-item dropdown">
            <button type="button" class="nav-link btn d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                <path d="M7 11l5 5l5 -5" />
                <path d="M12 4l0 12" />
              </svg><span class="ms-1 d-none d-sm-inline">Download</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="min-width: 150px">
              <li>
                <button class="dropdown-item py-2" id="down-txt">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-txt" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-2v-1h2a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.928 15.849v-3.337h1.136v-.662H0v.662h1.134v3.337h.794Zm4.689-3.999h-.894L4.9 13.289h-.035l-.832-1.439h-.932l1.228 1.983-1.24 2.016h.862l.853-1.415h.035l.85 1.415h.907l-1.253-1.992 1.274-2.007Zm1.93.662v3.337h-.794v-3.337H6.619v-.662h3.064v.662H8.546Z" />
                  </svg><span class="ms-2 fw-normal">Text file</span>
                </button>
              </li>
              <li>
                <button class="dropdown-item py-2" id="down-doc">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-word" viewBox="0 0 16 16">
                    <path d="M4.879 4.515a.5.5 0 0 1 .606.364l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 7.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 0 1 .364-.606z" />
                    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                  </svg><span class="ms-2 fw-normal">Doc file</span>
                </button>
              </li>
              <li>
                <button class="dropdown-item py-2" id="down-htm">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-html" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5Zm-9.736 7.35v3.999h-.791v-1.714H1.79v1.714H1V11.85h.791v1.626h1.682V11.85h.79Zm2.251.662v3.337h-.794v-3.337H4.588v-.662h3.064v.662H6.515Zm2.176 3.337v-2.66h.038l.952 2.159h.516l.946-2.16h.038v2.661h.715V11.85h-.8l-1.14 2.596H9.93L8.79 11.85h-.805v3.999h.706Zm4.71-.674h1.696v.674H12.61V11.85h.79v3.325Z" />
                  </svg><span class="ms-2 fw-normal">Html file</span>
                </button>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link btn btn-close btn-close-white py-2" onclick="javascript:location.href='<?php echo $this->url('my' . (!empty($_GET['r']) ? '/' . $_GET['r'] : null)); ?>'"></button>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <main>
    <div class="sidebar raitor-sidebar m-0" data-simplebar>
      <div class="p-3">
        <div id="templateForm" style="display: <?php echo empty($template) ? 'none' : 'block'; ?>;">
          <div class="mb-3">
            <button type="button" id="templateBack" class="btn fw-bold p-0 border-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 12l14 0" />
                <path d="M5 12l6 6" />
                <path d="M5 12l6 -6" />
              </svg> Back
            </button>
          </div>
          <form method="post" class="post-form " id="smart-editor">
            <?php if (!empty($template)) { ?>
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
                      <?php foreach ($languages as $val) {
                        if (!empty($language)) { ?>
                          <option value="<?php echo $val['name']; ?>" <?php echo $language == $val['name'] ? "selected" : null; ?>><?php echo $val['name']; ?></option>
                        <?php } else { ?>
                          <option value="<?php echo $val['name']; ?>" <?php echo $val['selected'] ? "selected" : (strtolower($val['name']) == 'english' ? "selected" : null); ?>><?php echo $val['name']; ?></option>
                      <?php }
                      } ?>
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
                          <option value="<?php echo $val['name']; ?>" <?php echo isset($tone) && $tone == $val['name'] ? "selected" : null; ?>><?php echo $val['name']; ?></option>
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
            <?php } ?>
          </form>
        </div>
        <div id="templateArea" style="display: <?php echo !empty($template) ? 'none' : 'block'; ?>;">
          <h6 class="fw-bold mb-3">All Template</h6>
          <div class="mb-3"><input type="text" name="search" id="templateSearch" class="form-control" placeholder="Search..." autocomplete="off"></div>
          <div class="row gy-3">
            <?php foreach ($templates as $template) { ?>
              <div class="col-12 templateItem">
                <a class="btn w-100 border p-2" href="<?php echo $this->url("my/editor?t=$template[slug]-" . base64_encode($template['id'])); ?>" data-template="<?php echo ($template['slug'] . "-" . base64_encode($template['id'])); ?>">
                  <div class="d-flex align-items-center">
                    <div class="rounded text-white d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px; background-color: <?php echo !empty($template['color']) ? $template['color'] : '#f4ac36'; ?>;">
                      <?php if (!empty($template['icon'])) {
                        echo $template['icon'];
                      } else { ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                          <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                          <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                        </svg>
                      <?php } ?>
                    </div>
                    <div class="fw-bold text-truncate templateTitle"><?php echo $template['title']; ?></div>
                  </div>
                </a>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="raitor-editor notranslate">
      <div id="raitor-editor"><?php echo isset($text) ? nl2br($text) : null; ?></div>
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
    <div class="modal fade" id="no-access-modal" tabindex="-1" aria-labelledby="noaccess" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body text-center py-4">
            <div class="mb-4 mx-auto text-warning">
              <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
              </svg>
            </div>
            <h3 class="fw-bold mb-3">Upgrade required</h3>
            <p class="text-muted fw-semibold fs-6 mb-4 error-message">Upgrade your plan to access premium templates.</p>
            <button type="button" class="btn btn-lg btn-primary fw-bold px-4" data-bs-dismiss="modal" aria-label="Close">OK</button>
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
    <div class="modal fade modal-sm" id="save-as" tabindex="-1" aria-labelledby="save as" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Save As</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" class="" novalidate>
              <div class="mb-4">
                <label class="form-label text-muted">Enter document name</label>
                <input type="text" name="name" class="form-control doc-name" minlength="3" maxlength="150" placeholder="e.g. New document">
              </div>
              <div class="py-2">
                <button type="button" class="btn btn-primary w-100" data-bs-toggle="save" data-bs-dismiss="modal" data-loader="Saving...">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>