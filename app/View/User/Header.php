<header>
    <nav class="navbar navbar-expand-lg navbar-light border-bottom fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <ul class="nav d-flex align-items-center">
                <li class="nav-item d-flex me-3">
                    <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-label="offcanvas">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php if ($this->setting['site_logo_light']) { ?>
                        <a href="<?php echo $this->url(null); ?>">
                            <img class="site-logo logo-light" src="<?php echo $this->url($this->setting['site_logo_light']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
                            <img class="site-logo logo-dark" src="<?php echo $this->url($this->setting['site_logo_dark']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
                        </a>
                    <?php } else { ?>
                        <a class="navbar-brand" href="<?php echo $this->url(null); ?>"><?php echo $this->setting['site_name']; ?></a>
                    <?php } ?>
                </li>
                <li class="nav-item d-none d-xl-flex">
                    <a class="nav-link" href="<?php echo $this->url('my/plans'); ?>">Plans & Pricing</a>
                </li>
                <?php if ($this->setting['affiliate_status']) { ?>
                    <li class="nav-item d-none d-xl-flex">
                        <a class="nav-link" href="<?php echo $this->url('my/referrals'); ?>">Refer & Earn</a>
                    </li>
                <?php } ?>
            </ul>
            <ul class="nav d-flex align-items-center">
                <li class="nav-item d-none d-md-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                        <symbol id="check2" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                        </symbol>
                        <symbol id="circle-half" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                        </symbol>
                        <symbol id="moon-stars-fill" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
                            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
                        </symbol>
                        <symbol id="sun-fill" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                        </symbol>
                    </svg>
                    <div class="dropdown bd-mode-toggle">
                        <button class="btn d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                            <svg class="bi theme-icon-active" width="1.1em" height="1.1em">
                                <use href="#circle-half"></use>
                            </svg>
                            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
                            <span class="ms-2 fw-semibold">Mode</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text" style="min-width: 150px;">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center py-2" data-bs-theme-value="light" aria-pressed="false">
                                    <svg class="bi me-3 theme-icon" width="1em" height="1em">
                                        <use href="#sun-fill"></use>
                                    </svg>
                                    Light
                                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                                        <use href="#check2"></use>
                                    </svg>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center py-2" data-bs-theme-value="dark" aria-pressed="false">
                                    <svg class="bi me-3 theme-icon" width="1em" height="1em">
                                        <use href="#moon-stars-fill"></use>
                                    </svg>
                                    Dark
                                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                                        <use href="#check2"></use>
                                    </svg>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center py-2 active" data-bs-theme-value="auto" aria-pressed="true">
                                    <svg class="bi me-3 theme-icon" width="1em" height="1em">
                                        <use href="#circle-half"></use>
                                    </svg>
                                    Auto
                                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                                        <use href="#check2"></use>
                                    </svg>
                                </button>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item d-none d-lg-flex">
                    <a class="btn fw-bold d-flex align-items-center" href="<?php echo $this->url('my/chat'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1"></path>
                        </svg><span class="ms-1">Chat</span>
                    </a>
                </li>
                <li class="nav-item d-none d-md-flex ms-2">
                    <a class="btn fw-bold d-flex align-items-center btn-primary" href="<?php echo $this->url('my/templates'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg><span class="ms-1 d-none d-lg-inline">Create Content</span>
                    </a>
                </li>
                <li class="nav-item ms-3">
                    <div class="dropdown">
                        <button type="button" class="btn btn-dark rounded-circle border border-1 p-0 fw-bold fs-6" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <div class="d-flex align-items-center my-3" style="width: 200px;">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-square-rounded" width="40" height="40" viewBox="0 0 24 24" stroke-width="0.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z"></path>
                                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                                            <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-grow-1 ms-2 text-truncate">
                                        <div class="fw-semibold"><?php echo $this->user['name']; ?></div>
                                        <small><?php echo $this->user['email']; ?></small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a href="<?php echo $this->url('my/plans'); ?>" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning-charge-fill" viewBox="0 0 16 16">
                                        <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z" />
                                    </svg><span class="ms-3">Upgrade Plan</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $this->url('my/history'); ?>" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-history" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 8l0 4l2 2"></path>
                                        <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"></path>
                                    </svg><span class="ms-3">My History</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $this->url('my/usage'); ?>" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-line" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 19l16 0"></path>
                                        <path d="M4 15l4 -6l4 2l4 -5l4 4"></path>
                                    </svg><span class="ms-3">Usage History</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $this->url('my/billing'); ?>" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                        <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                                        <path d="M12 7v10"></path>
                                    </svg><span class="ms-3">Plans and Billing</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $this->url('my/account'); ?>" class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-square-rounded" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z"></path>
                                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                                            <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05"></path>
                                        </svg><span class="ms-3">Account Details</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a href="<?php echo $this->url('logout'); ?>" class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                            <path d="M9 12h12l-3 -3" />
                                            <path d="M18 15l3 -3" />
                                        </svg><span class="ms-3">Log Out</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>