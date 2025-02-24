<header>
    <nav class="navbar navbar-expand-md navbar-light fixed-top" id="navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <ul class="nav d-flex align-items-center">
                <li class="nav-item d-flex me-3">
                    <?php if ($this->setting['site_logo_light']) { ?>
                        <a href="<?php echo $this->url(null); ?>">
                            <img class="site-logo logo-light" src="<?php echo $this->url($this->setting['site_logo_light']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
                            <img class="site-logo logo-dark" src="<?php echo $this->url($this->setting['site_logo_dark']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
                        </a>
                    <?php } else { ?>
                        <a class="navbar-brand" href="<?php echo $this->url(null); ?>"><?php echo $this->setting['site_name']; ?></a>
                    <?php } ?>
                </li>
            </ul>
            <ul class="nav d-flex align-items-center">
                <?php if ($this->setting['frontend_status']) { ?>
                    <li class="nav-item">
                        <a class="nav-link d-none d-md-flex align-items-center" href="<?php echo $this->url('#use-cases'); ?>">Use Cases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-none d-md-flex align-items-center" href="<?php echo $this->url('#pricing'); ?>">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-none d-md-flex align-items-center" href="<?php echo $this->url('#faq'); ?>">Faq</a>
                    </li>

                    <?php if (!empty($this->setting['blog_status'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link d-none d-md-flex align-items-center" href="<?php echo $this->url('blog'); ?>">Blog</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link d-none d-md-flex align-items-center" href="<?php echo $this->url('contact'); ?>">Support</a>
                    </li>
                <?php } ?>
            </ul>
            <ul class="nav d-flex align-items-center">
                <?php if ($this->uid) { ?>
                    <li class="nav-item">
                        <a class="nav-link align-items-center" href="<?php echo $this->url('my'); ?>">Account</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link align-items-center" href="<?php echo $this->url('login'); ?>">Log In</a>
                    </li>
                    <li class="nav-item d-none d-md-inline">
                        <a class="nav-link align-items-center signup" href="<?php echo $this->url('signup'); ?>">Sign Up</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>