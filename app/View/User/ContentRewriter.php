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
        <div class="row justify-content-center">
          <div class="col-12 col-xl-9">
            <div class="text-center mb-4">
              <h2 class="fw-bold">Rewrite content</h2>
              <p>AI to rewrite the current content and generate fresh, captivating content that stands out.</p>
            </div>
            <form method="post" class="post-form" id="content-rewriter">
              <div class="card p-3 mb-3">
                <div class="row gx-3 mb-3">
                  <?php if (!empty($languages)) { ?>
                    <div class="col">
                      <label class="form-label">Language</label>
                      <select name="language" id="raitor-language" class="form-select">
                        <?php foreach ($languages as $val) { ?>
                          <option value="<?php echo $val['name']; ?>" <?php echo $val['selected'] ? "selected" : (strtolower($val['name']) == 'english' ? "selected" : null); ?>><?php echo $val['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } ?>
                  <?php if (!empty($tones)) { ?>
                    <div class="col">
                      <label class="form-label">Tone</label>
                      <select name="tone" id="raitor-tone" class="form-select">
                        <option value="Default" selected>Default</option>
                        <?php foreach ($tones as $val) { ?>
                          <option value="<?php echo $val['name']; ?>"><?php echo $val['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } ?>
                </div>
                <div>
                  <label class="form-label small">What would you like to rewrite?</label>
                  <textarea name="text" class="form-control autosize" rows="10" maxlength="8000" placeholder="Paste the content here" required></textarea>
                </div>
              </div>
              <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary fw-semibold px-5" style="min-width: 280px">Start rewriting
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-down-up ms-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z" />
                  </svg>
                </button>
              </div>
            </form>
            <div id="results" class="card mb-5" style="display: none;">
              <div class="card-header border-bottom-0 bg-transparent d-flex justify-content-between">
                <div class="pt-2 text-dark fw-semibold"></div>
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
                </div>
              </div>
              <div class="p-3 mb-4">
                <div class="markdown ai-content notranslate"></div>
                <span class="result-thinking"></span>
              </div>
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
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php require_once APP . '/View/User/Tail.php'; ?>
  <script>
    const clipboard = new ClipboardJS(".btn-clipboard", {
      target: e => e.closest(".card").querySelector(".ai-content").html,
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