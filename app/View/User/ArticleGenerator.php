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
        <div class="row justify-content-center" id="info">
          <div class="col-12 col-xl-9 col-xxl-8">
            <form method="post" class="post-form" id="article-generator">
              <div class="text-center mb-4">
                <h2 class="fw-bold">Generate Articles</h2>
                <p>AI to transforming a title and outline into a long and engaging article.</p>
              </div>
              <div class="card p-3 mb-4">
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
                </div>
                <div class="mb-3">
                  <label class="form-label small">Focus keywords separated with a comma (optional)</label>
                  <input type="text" name="keyword" class="form-control" maxlength="50" placeholder="e.g. Book writing, Science fiction, Creativity">
                </div>
                <div class="mb-1">
                  <label class="form-label small">Article title</label>
                  <textarea name="title" class="form-control autosize" rows="3" minlength="10" maxlength="1200" placeholder="e.g. Tips for becoming a better writer" required></textarea>
                </div>
              </div>
              <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary fw-semibold px-5" style="min-width: 280px">Write Article
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                  </svg>
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="card article" id="results" style="display: none;">
          <div class="card-header bg-transparent d-flex justify-content-between">
            <div>
              <button type="button" class="btn btn-sm border" id="back-article">
                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-arrow-left" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M5 12l14 0"></path>
                  <path d="M5 12l6 6"></path>
                  <path d="M5 12l6 -6"></path>
                </svg><span class="ms-1">Back</span>
              </button>
            </div>
            <div class="btn-group clipboard shadow-sm">
              <button type="button" class="btn btn-sm border btn-clipboard" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy to clipboard" data-copied-title="Copied!">
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
              <button type="button" class="btn btn-sm border" id="btn-save" title="" data-doc="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Save to document" data-copied-title="Saved!">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                  <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M14 4l0 4l-6 0l0 -4" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M5 12l5 5l10 -10" />
                </svg>
              </button>
              <button type="button" class="btn btn-sm border" title="" id="download-file" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download as file" data-copied-title="Copied!">
                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-download" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                  <path d="M7 11l5 5l5 -5"></path>
                  <path d="M12 4l0 12"></path>
                </svg>
              </button>
            </div>
          </div>
          <div class="col-12 col-xl-10 mx-auto p-3 p-xl-5">
            <div class="markdown ai-content notranslate"></div>
            <span class="result-thinking"></span>
          </div>
        </div>
      </div>
    </div>
  </main>
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
  <div class="modal fade" id="save-as" tabindex="-1" aria-labelledby="save as" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Save As</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" class="" novalidate>
            <div class="mb-4">
              <label class="form-label text-muted">Document name</label>
              <input type="text" name="name" class="form-control doc-name" minlength="3" maxlength="150" placeholder="e.g. New document">
            </div>
            <div class="py-2">
              <button type="button" class="btn btn-primary w-100" id="save" data-bs-dismiss="modal" data-loader="Saving...">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
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

    $('#btn-save').click(function(e) {
      var nam = $('textarea[name="title"]').val();
      $('#save-as input[name="name"]').val(nam);
      $('#save-as').modal('show');
    });

    $('#save').click(function(e) {
      e.preventDefault();
      var nam = $('input[name="name"]').val();
      var txt = $('.ai-content').html();
      $('#btn-save .icon-tabler-device-floppy').hide();
      $('#btn-save .icon-tabler-check').show();
      $('#btn-save').prop('disabled', true);
      $.post("", {
        name: nam,
        text: txt
      }, function(response) {
        setTimeout(function() {
          $('#btn-save .icon-tabler-device-floppy').show();
          $('#btn-save .icon-tabler-check').hide();
          $('#btn-save').prop('disabled', false);
        }, 3000);
      });
    });
    $('#download-file').click(function(e) {
      var filename = $('textarea[name="title"]').val();
      var text = $('.ai-content').html();
      downloadFile(text.replace(/<br\s*[\/]?>/gi, '\n'), filename.trim() + ".txt", 'plain/text');
    });
  </script>
</body>

</html>