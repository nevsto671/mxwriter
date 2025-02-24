    <div class="sidebar z-3" data-simplebar>
      <div class="offcanvas offcanvas-start border-0" tabindex="-1" id="offcanvas" aria-labelledby="offcanvas">
        <div class="offcanvas-header d-lg-none">
          <h5 class="offcanvas-title" id="offcanvasLabel"><a class="navbar-brand text-dark" href="<?php echo $this->url(null); ?>" aria-label="logo"><?php echo $this->setting['site_name']; ?></a></h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body pb-lg-0 px-lg-0 mt-lg-4 mb-4">
          <?php if ($this->user['plan_id'] == $this->setting['free_plan']) { ?>
            <div class="mb-4 px-md-2 px-lg-3">
              <div class="d-flex justify-content-between mb-2">
                <div class="fw-bold me-2 text-nowrap">Credits</div>
                <div class="text-muted text-truncate">
                  <span class="fw-semibold" id="credit-words"><?php echo $this->user['words']; ?></span> words left
                </div>
              </div>
              <div class="mb-3">
                <div class="progress progress-bar-animated" role="progressbar" aria-label="percentage-left" aria-valuenow="<?php echo $this->usage_percentage_left; ?>" aria-valuemin="0" aria-valuemax="100" style="height: 7px">
                  <div class="progress-bar text-bg-success" style="width: <?php echo $this->usage_percentage_left; ?>%"></div>
                </div>
              </div>
              <div class="mb-3">
                <a class="btn btn-primary fw-semibold w-100" href="<?php echo $this->url('my/plans'); ?>">
                  <span class="me-1">Upgrade</span>
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gold" class="bi bi-lightning-charge-fill" viewBox="0 0 16 16">
                      <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z" />
                    </svg>
                  </span>
                </a>
              </div>
            </div>
          <?php } ?>
          <div class="position-relative">
            <ul class="nav flex-column sidebar-menu">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->url('my'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-smart-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M19 8.71l-5.333 -4.148a2.666 2.666 0 0 0 -3.274 0l-5.334 4.148a2.665 2.665 0 0 0 -1.029 2.105v7.2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-7.2c0 -.823 -.38 -1.6 -1.03 -2.105"></path>
                    <path d="M16 15c-2.21 1.333 -5.792 1.333 -8 0"></path>
                  </svg><span class="ms-3">Dashboard</span>
                </a>
              </li>
              <?php if ($this->setting['template_status']) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('my/templates'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-box-multiple" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M7 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                      <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2"></path>
                    </svg><span class="ms-3">Templates</span>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->setting['chat_status']) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('my/chat'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1"></path>
                    </svg><span class="ms-3">Assistants</span>
                  </a>
                </li>
              <?php } ?>
              <li class="nav-item divider">
                <span class="text-muted fw-semibold">Workflows</span>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->url('my/analyst'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-analytics">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 17l0 -5" />
                    <path d="M12 17l0 -1" />
                    <path d="M15 17l0 -3" />
                  </svg><span class="ms-3">Data Analyst</span>
                </a>
              </li>
              <?php if ($this->setting['article_status']) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('my/article-generator'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-description">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                      <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                      <path d="M9 17h6" />
                      <path d="M9 13h6" />
                    </svg><span class="ms-3">Article Generator</span>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->setting['image_status']) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('my/image-generator'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M15 8h.01"></path>
                      <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path>
                      <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
                      <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
                    </svg><span class="ms-3">Image Generator</span>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->setting['rewrite_status']) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('my/content-rewriter'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-pencil">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                      <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                      <path d="M10 18l5 -5a1.414 1.414 0 0 0 -2 -2l-5 5v2h2z" />
                    </svg><span class="ms-3">Content Rewriter</span>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->setting['editor_status']) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('my/editor'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notebook" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18"></path>
                      <path d="M13 8l2 0"></path>
                      <path d="M13 12l2 0"></path>
                    </svg><span class="ms-3">Smart Editor</span>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->setting['document_status']) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('my/documents'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2"></path>
                    </svg><span class="ms-3">Documents</span>
                  </a>
                </li>
              <?php } ?>
              <li class="nav-item divider">
                <span class="text-muted fw-semibold">Accounts</span>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->url('my/history'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-history" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 8l0 4l2 2"></path>
                    <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"></path>
                  </svg><span class="ms-3">My History</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->url('my/usage'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-line" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 19l16 0"></path>
                    <path d="M4 15l4 -6l4 2l4 -5l4 4"></path>
                  </svg><span class="ms-3">Usage History</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->url('my/billing'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                    <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                    <path d="M12 7v10"></path>
                  </svg><span class="ms-3">Plans and Billing</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->url('my/account'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-square-rounded" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z"></path>
                    <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                    <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05"></path>
                  </svg><span class="ms-3">Account Details</span>
                </a>
              </li>
              <?php if ($this->rid == 1) { ?>
                <li class="nav-item divider">
                  <span class="text-muted fw-semibold">Admin panel</span>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-pie-3" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M12 12l-6.5 5.5" />
                      <path d="M12 3v9h9" />
                      <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    </svg><span class="ms-3">Dashboard</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/templates'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layers-intersect" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M8 4m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                      <path d="M4 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                    </svg><span class="ms-3">Templates</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/assistants'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-chatbot" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"></path>
                      <path d="M9.5 9h.01"></path>
                      <path d="M14.5 9h.01"></path>
                      <path d="M9.5 13a3.5 3.5 0 0 0 5 0"></path>
                    </svg><span class="ms-3">Assistants</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/subscriptions'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                      <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                      <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" />
                    </svg><span class="ms-3">Subscriptions</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/transactions'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                      <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                      <path d="M12 7v10" />
                    </svg><span class="ms-3">Transactions</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/plans'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-businessplan" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M16 6m-5 0a5 3 0 1 0 10 0a5 3 0 1 0 -10 0" />
                      <path d="M11 6v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                      <path d="M11 10v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                      <path d="M11 14v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                      <path d="M7 9h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                      <path d="M5 15v1m0 -8v1" />
                    </svg><span class="ms-3">Plans</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/blogs'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-article" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                      <path d="M7 8h10" />
                      <path d="M7 12h10" />
                      <path d="M7 16h10" />
                    </svg><span class="ms-3">Blogs</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/pages'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-files" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                      <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                      <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                    </svg><span class="ms-3">Pages</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/users'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                      <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                      <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                      <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg><span class="ms-3">Users</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->url('admin/settings'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                      <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg><span class="ms-3">Settings</span>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>