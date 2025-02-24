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
        <div class="mb-5 d-none d-lg-block">
          <h2 class="fw-bold">Hello, <?php echo $this->first_name(); ?> <span class="text-muted h3 fw-bold"></span></h2>
        </div>
        <div class="mb-5">
          <div class="row g-4">
            <div class="col-12 col-md-3 col-md-auto">
              <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold text-muted">Words Generated</h6>
                <h6 class="fw-bold mb-0"><?php echo number_format($user['words_generated']); ?> words</h6>
              </div>
            </div>
            <?php if ($this->setting['image_status']) { ?>
              <div class="col-12 col-md-3 col-md-auto">
                <div class="card border-0 shadow-sm p-3 h-100">
                  <h6 class="fw-bold text-muted">Images Generated</h6>
                  <h6 class="fw-bold mb-0"><?php echo number_format($user['images_generated']); ?> images</h6>
                </div>
              </div>
            <?php } ?>
            <div class="col-12 col-md-3 col-md-auto">
              <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold text-muted">Credits Left</h6>
                <h6 class="fw-bold mb-0"><?php echo is_null($user['words']) ? 'Unlimited' : number_format($user['words']); ?> words</h6>
              </div>
            </div>
            <div class="col-12 col-md-3 col-md-auto">
              <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold text-muted">Time Saved</h6>
                <h6 class="fw-bold mb-0"><?php echo $time_saved; ?> hours</h6>
              </div>
            </div>
          </div>
        </div>
        <?php if (!empty($recent_history)) { ?>
          <div class="mb-5">
            <div class="d-flex justify-content-between mb-3">
              <div>
                <h4 class="fw-bold">Recent History</h4>
              </div>
              <div>
              </div>
            </div>
            <div class="row g-4" id="tab-content">
              <?php foreach ($recent_history as $template) { ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
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
          </div>
        <?php } ?>
        <?php if (!empty($popular_history)) { ?>
          <div class="mb-5">
            <div class="d-flex justify-content-between mb-3">
              <div>
                <h4 class="fw-bold">Most Popular</h4>
              </div>
              <div>
              </div>
            </div>
            <div class="row g-4" id="tab-content">
              <?php foreach ($popular_history as $template) { ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
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
          </div>
        <?php } ?>
        <?php if (!empty($random_history)) { ?>
          <div class="mb-5">
            <div class="d-flex justify-content-between mb-3">
              <div>
                <h4 class="fw-bold">For You</h4>
              </div>
              <div>
                <a class="btn btn-light" href="<?php echo $this->url("my/templates"); ?>">All Tools <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                  </svg>
                </a>
              </div>
            </div>
            <div class="row g-4" id="tab-content">
              <?php foreach ($random_history as $template) { ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
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
          </div>
        <?php } ?>
      </div>
    </div>
  </main>
  <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>