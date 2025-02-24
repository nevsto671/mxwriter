<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
    <?php require_once __DIR__ . '/Head.php'; ?>
</head>

<body>
    <?php if ($this->setting['gtranslate']) { ?>
        <div class="m-3 text-end">
            <div class="gtranslate_wrapper"></div>
        </div>
    <?php } ?>
    <main class="py-4 py-lg-5">
        <div class="container">
            <div class="text-center mb-5">
                <?php if ($this->setting['site_logo_light']) { ?>
                    <a href="<?php echo $this->url(null); ?>">
                        <img class="site-logo logo-light" src="<?php echo $this->url($this->setting['site_logo_light']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
                        <img class="site-logo logo-dark" src="<?php echo $this->url($this->setting['site_logo_dark']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
                    </a>
                <?php } else { ?>
                    <a class="navbar-brand" href="<?php echo $this->url(null); ?>"><?php echo $this->setting['site_name']; ?></a>
                <?php } ?>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12 col-lg-5 mb-3 mb-md-0">
                    <div class="mx-auto" style="max-width: 320px">
                        <?php if (!empty($_GET['token']) && $validToken) { ?>
                            <form method="post" class="mb-4" id="password-update-form">
                                <div class="text-center mb-4">
                                    <h5 class="text-center mb-4 fw-bold">Create a new password</h5>
                                    <p class="small">Please enter a new password for your account.</p>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter your new password" minlength="8" maxlength="20" autocomplete="new-password" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Confirm password</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Retype your new password" minlength="8" maxlength="20" autocomplete="new-password" required>
                                </div>
                                <div class="text-center text-danger small error-message"></div>
                                <div class="pt-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2" data-token="<?php echo isset($_GET['token']) ? $_GET['token'] : null; ?>">Change password</button>
                                </div>
                            </form>
                            <div id="pass-change-success" class="alert alert-success text-center" style="display: none;"></div>
                        <?php } else { ?>
                            <form method="post" class="mb-4" id="pass-reset-form">
                                <?php if (!empty($_GET['token']) && !$validToken) { ?>
                                    <div class="alert alert-danger text-center">
                                        The password reset link has expired.
                                    </div>
                                <?php } ?>
                                <div class="mb-4 text-center">
                                    <h5 class="text-center mb-4 fw-bold">Reset your password</h5>
                                    <p>Enter the email address you used when you created the account. You will receive an email with the information for change your password.</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Your email address" autocomplete="username" required>
                                </div>
                                <div class="text-center text-danger small error-message mb-2"></div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2" data-loader="">Submit</button>
                                </div>
                            </form>
                            <div id="pass-reset-success" class="alert alert-success text-center" style="display: none;"></div>
                            <div class="text-center">
                                <a class="text-decoration-none" href="<?php echo $this->url('login'); ?>">Back to login</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once __DIR__ . '/Tail.php'; ?>
</body>

</html>