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
                <?php if ($flash = $this->flash()) { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-2">
                        <div class="col-md-8 col-lg-8 col-xl-7 offset-lg-1">
                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($_GET['email'])) { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-5">
                        <div class="col-md-8 col-lg-8 col-xl-7 offset-lg-1">
                            <div class="card border-0 p-3">
                                <h5 class="fw-bold mb-4">Email address verification</h5>
                                <form method="post" class="form validation" novalidate>
                                    <p class="text-muted">We need you to verify your email address before add. We just sent your verification code via email. Please enter the verification code below.</p>
                                    <div class="mb-4">
                                        <input type="tel" name="code" class="form-control" placeholder="Verification code" autocomplete="one-time-code" maxlength="12" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="current-password-input" class="form-label fw-semibold">Current password</label>
                                        <input type="password" name="password" class="form-control" id="current-password-input" placeholder="Enter your current password" minlength="8" maxlength="20" autocomplete="current-password" required>
                                    </div>
                                    <div class="py-2">
                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Verify</button>
                                        <a href="<?php echo $this->url("my/account"); ?>" class="btn btn-light ms-2">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-md-8 col-lg-8 col-xl-7 offset-lg-1">
                            <div class="card border-0 p-3">
                                <h5 class="fw-bold mb-4">Account information</h5>
                                <?php if (isset($user['status']) && $user['status'] == 2) { ?>
                                    <div class="p-2 alert alert-warning">Please verify your email address by clicking the link in the email we sent you. If you didn't receive the email, you can resend it here. <a href="<?php echo $this->url("my/account?verification=" . md5(date('Ymd'))); ?>">Resend</a></div>
                                <?php } ?>
                                <form method="post" class="form validation" novalidate>
                                    <div class="mb-4">
                                        <label for="name-input" class="form-label fw-semibold">Name</label>
                                        <input type="text" name="name" class="form-control notranslate" id="name-input" minlength="4" value="<?php echo isset($user['name']) ? $user['name'] : null; ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="email-input" class="form-label fw-semibold">Email</label>
                                        <input type="email" name="email" class="form-control notranslate" id="email-input" value="<?php echo isset($user['email']) ? $user['email'] : null; ?>">
                                    </div>
                                    <div class="">
                                        <button type="submit" class="btn btn-primary py-2" data-loader="Updating...">Update details</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-md-8 col-lg-8 col-xl-7 offset-lg-1">
                            <div class="card border-0 p-3">
                                <h5 class="fw-bold mb-4">Change password</h5>
                                <form method="post" class="form validation" novalidate>
                                    <div class="mb-4">
                                        <label for="current-password-input" class="form-label fw-semibold">Current password</label>
                                        <input type="password" name="current_password" class="form-control" id="current-password-input" placeholder="Enter your current password" minlength="8" maxlength="20" autocomplete="current-password" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="new-password-input" class="form-label fw-semibold">New password</label>
                                        <input type="password" name="new_password" class="form-control" id="new-password-input" placeholder="Enter your new password" minlength="8" maxlength="20" autocomplete="new-password" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="confirm-password-input" class="form-label fw-semibold">Confirm password</label>
                                        <input type="password" name="confirm_password" class="form-control" id="confirm-password-input" placeholder="Retype your new password" minlength="8" maxlength="20" autocomplete="confirm-password" required>
                                    </div>
                                    <div class="">
                                        <button type="submit" class="btn btn-primary py-2" data-loader="Saving...">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>