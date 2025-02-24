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
        <div class="col-xxl-10 mx-auto">
          <form method="post" class="post-form" id="image-generator">
            <div class="d-flex justify-content-between align-items-end mb-1">
              <h2 class="fw-bold mb-3">Image Generator</h2>
              <div class="my-2">
                <div class="form-check form-switch" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create an image by input prompt only.">
                  <input class="form-check-input py-2" type="checkbox" name="prompt" role="switch">
                </div>
              </div>
            </div>
            <div class="card p-3 border-0 mb-4" style="border-radius: 1rem;">
              <div class="chatbox d-flex align-items-end position-relative">
                <textarea id="description" name="description" maxlength="4000" placeholder="Write image description here..." class="form-control autosize" style="border-radius: 1rem; padding-right: 140px;" required></textarea>
                <button type="submit" class="btn btn-primary position-absolute end-0 me-2 rounded-pill" style="margin-bottom: 11px;">Generate <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                  </svg>
                </button>
              </div>
              <div class="mt-3">
                <div class="row g-3">
                  <div class="col-6 col-lg-3">
                    <select name="style" class="form-select">
                      <option value="" selected disabled>Style</option>
                      <option value="none">None</option>
                      <option value="3d render">3d Render</option>
                      <option value="abstract">Abstract</option>
                      <option value="anime">Anime</option>
                      <option value="art deco">Art Deco</option>
                      <option value="artwork">Artwork</option>
                      <option value="cartoon">Cartoon</option>
                      <option value="digital art">Digital Art</option>
                      <option value="illustration">Illustration</option>
                      <option value="line art">Line Art</option>
                      <option value="one line drawing">One Line Drawing</option>
                      <option value="origami">Origami</option>
                      <option value="pixel art">Pixel Art</option>
                      <option value="photography">Photography</option>
                      <option value="photography">Photorealistic</option>
                      <option value="pop art">Pop Art</option>
                      <option value="retro">Retro</option>
                      <option value="unreal engine">Unreal Engine</option>
                      <option value="vaporwave">Vaporwave</option>
                    </select>
                  </div>
                  <div class="col-6 col-lg-3">
                    <select name="lighting" class="form-select">
                      <option value="" selected disabled>Lighting</option>
                      <option value="none">None</option>
                      <option value="accent">Accent</option>
                      <option value="ambient">Ambient</option>
                      <option value="blue hour">Blue Hour</option>
                      <option value="cinematic">Cinematic</option>
                      <option value="cold">Cold</option>
                      <option value="decorative">Decorative</option>
                      <option value="dramatic">Dramatic</option>
                      <option value="hard">Hard</option>
                      <option value="foggy">Foggy</option>
                      <option value="natural">Natural</option>
                      <option value="neon">Neon</option>
                      <option value="studio">Studio</option>
                      <option value="soft">Soft</option>
                      <option value="warm">Warm</option>
                    </select>
                  </div>
                  <div class="col-6 col-lg-3">
                    <select name="medium" class="form-select">
                      <option value="" selected disabled>Medium</option>
                      <option value="none">None</option>
                      <option value="acrylics">Acrylics</option>
                      <option value="canvas">Canvas</option>
                      <option value="chalk">Chalk</option>
                      <option value="charcoal">Charcoal</option>
                      <option value="classic oil">Classic Oil</option>
                      <option value="crayon">Crayon</option>
                      <option value="glass">Glass</option>
                      <option value="ink">Ink</option>
                      <option value="modern oil painting">Modern Oil Painting</option>
                      <option value="pastel">Pastel</option>
                      <option value="pencil">Pencil</option>
                      <option value="spray paint">Spray Paint</option>
                      <option value="water color painting">Water Color Painting</option>
                      <option value="wood panel">Wood Panel</option>
                    </select>
                  </div>
                  <div class="col-6 col-lg-3">
                    <select name="mood" class="form-select">
                      <option value="" selected disabled>Mode</option>
                      <option value="none">None</option>
                      <option value="aggressive">Aggressive</option>
                      <option value="angry">Angry</option>
                      <option value="boring">Boring</option>
                      <option value="bright">Bright</option>
                      <option value="calm">Calm</option>
                      <option value="cheerful">Cheerful</option>
                      <option value="chilling">Chilling</option>
                      <option value="colorful">Colorful</option>
                      <option value="dark">Dark</option>
                      <option value="neutral">Neutral</option>
                    </select>
                  </div>
                </div>
              </div>
          </form>
        </div>
        </form>
        <div>
          <div class="text-center py-5 mb-5" id="result-error" style="display: none;">
            <div class="mb-3 mx-auto text-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
              </svg>
            </div>
            <h5 class="fw-bold mb-4 text-muted">Generation Failed</h5>
            <p class="text-muted">Something went wrong, please try again.</p>
          </div>
          <div class="text-center py-5 mb-5" id="no-credits" style="display: none;">
            <div class="mb-3 mx-auto text-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
              </svg>
            </div>
            <h5 class="fw-bold mb-4 text-muted">Insufficient Credits</h5>
            <p class="text-muted">Sorry, you do not have enough credits to generate images. Please upgrade your current plan.</p>
            <a class="btn btn-primary fw-semibold" href="<?php echo $this->url('my/plans'); ?>">Upgrade Plan</a>
          </div>
          <div class="row g-3" id="results">
            <?php if ($images) { ?>
              <?php foreach ($images as $image) { ?>
                <div class="col-6 col-xl-4 col-xxl-3 col-img">
                  <div class="card lightbox-gallery">
                    <img src="<?php echo $image['thumb']; ?>" class="card-img" alt="image" data-toggle="lightbox" data-src="<?php echo $this->url($image['thumb']); ?>" data-caption="<?php echo htmlspecialchars($image['description']); ?>">
                    <div class="card-overlay">
                      <div class="d-flex justify-content-center">
                        <div>
                          <a class="btn btn-sm btn-light" target="_blank" href="<?php echo $this->url("my/image-generator?download=$image[id]"); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                              <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                              <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                            </svg>
                          </a>
                        </div>
                        <div class="ms-2">
                          <button type="button" class="btn btn-sm btn-light delete_img" data-id="<?php echo $image['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                            </svg>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <div class="d-flex justify-content-center">
                <nav class="my-4"><?php echo $pagination; ?></nav>
              </div>
            <?php } else { ?>
              <div class="text-center py-5" id="result-info">
                <h3 class="fw-bold mb-3">Image Generator</h3>
                <p class="text-muted">Generate professional quality images from text for your blog or website.</p>
                <div class="text-muted mb-4">
                  Generate results by filling up the form on the top and clicking on "Generate".
                </div>
                <p class="text-muted">Your generation image by artificial intelligence will appear here.</p>
              </div>
            <?php } ?>

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
                  <p class="text-muted fw-semibold fs-6 mb-4">Sorry, you have exhausted your credits for generating more images. Please upgrade your account.</p>
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
                  <p class="text-muted fw-semibold fs-6 mb-4">Your request is too short, please add more details.</p>
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
</body>

</html>