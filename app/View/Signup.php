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
            <div class="row justify-content-center mb-5">
                <div class="col-sm-12 col-lg-5 mb-3 mb-md-0">
                    <div class="mx-auto" style="max-width: 320px">
                        <h5 class="text-center mb-4 fw-bold">Create your account</h5>
                        <form method="post" id="email-verification-form" style="display: none">
                            <p class="text-muted">
                                <b>Email verification</b><br>We need you to verify your email before create your account. We just sent your verification code via email. Please check your email and enter the verification code below.
                            </p>
                            <div class="mb-2">
                                <label class="form-label fw-semibold">Code</label>
                                <input type="tel" name="verification_code" class="form-control" placeholder="Verification code" autocomplete="one-time-code" maxlength="12" required>
                            </div>
                            <div class="text-center text-danger small error-message mb-2"></div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary py-2 w-100">Verify</button>
                            </div>
                            <div class="text-center resend-code">
                                <button type="button" class="btn btn-link btn-resend p-0" style="display: none;" disabled>Resend OTP</button>
                            </div>
                        </form>
                        <div id="email-signup" id="redirect" data-redirect="<?php echo $this->url(isset($_GET['redirect']) ? $_GET['redirect'] : 'my'); ?>">
                            <?php if (!empty($provider_results)) { ?>
                                <?php if (!empty($provider['Google']['status'])) { ?>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-spinner bg-white text-dark w-100 border" onclick="window.location.href='<?php echo $this->url('login/google'); ?>';">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 48 48">
                                                <path fill="#4285F4" d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"></path>
                                                <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"></path>
                                                <path fill="#FBBC05" d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24c0 3.55.85 6.91 2.34 9.88l7.35-5.7z"></path>
                                                <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"></path>
                                            </svg><span class="ms-2">Continue with Google</span>
                                        </button>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($provider['Facebook']['status'])) { ?>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-light btn-spinner text-white w-100" style="background-color: #4267b2;" onclick="window.location.href='<?php echo $this->url('login/facebook'); ?>';">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                            </svg><span class="ms-2">Continue with Facebook</span>
                                        </button>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($provider['LinkedIn']['status'])) { ?>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-light btn-spinner text-white w-100" style="background-color: #0077b5;" onclick="window.location.href='<?php echo $this->url('login/linkedin'); ?>';">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-linkedin" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                                <path d="M8 11l0 5" />
                                                <path d="M8 8l0 .01" />
                                                <path d="M12 16l0 -5" />
                                                <path d="M16 16v-3a2 2 0 0 0 -4 0" />
                                            </svg><span class="ms-2">Continue with LinkedIn</span>
                                        </button>
                                    </div>
                                <?php } ?>
                                <div class="text-center py-1 fw-bold">OR</div>
                            <?php } ?>
                            <form method="post" id="email-signup-form">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Your name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Your name" autocomplete="name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email address" autocomplete="username" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" maxlength="40" autocomplete="new-password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Confirm password</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" maxlength="40" autocomplete="new-password" required>
                                </div>
                                <div class="text-center text-danger small error-message mb-2"></div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary btn-submit py-2 w-100" data-loader="Submiting...">Continue</button>
                                </div>
                                <div class="text-center fw-semibold">
                                    Already have an account? <a class="text-decoration-none" href="<?php echo $this->url('login'); ?>">Log In</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($this->setting['frontend_status']) { ?>
                <div class="text-center py-5">
                    <a class="text-decoration-none" href="<?php echo $this->url('terms'); ?>" target="_blank">Terms of use</a><span class="px-2 small">|</span><a class="text-decoration-none" href="<?php echo $this->url('privacy-policy'); ?>" target="_blank">Privacy policy</a>
                </div>
            <?php } ?>
        </div>
    </main>
    <?php require_once __DIR__ . '/Tail.php'; ?>
</body>

</html>