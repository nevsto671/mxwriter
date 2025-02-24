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
                <div class="row justify-content-center justify-content-lg-start mb-4">
                    <div class="col-md-8 col-lg-8 col-xl-7 offset-lg-1">
                        <div class="card border-0 p-3">
                            <h5 class="fw-bold mb-3">Payment methods</h5>
                            <?php if ($flash = $this->flash()) { ?>
                                <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                            <?php } ?>
                            <p class="mb-4">Recurring subscription charges will be billed to your payment method.</p>
                            <div class="mb-2">
                                <?php if (!empty($payment)) { ?>
                                    <div class="d-flex align-items-center my-4">
                                        <img width="40" height="40" src="<?php echo $this->url('assets/img/payment/' . strtolower($payment['provider']) . '.png'); ?>">
                                        <span class="ms-3">
                                            <span class="fw-bold d-block h5 m-0"><?php echo $payment['name']; ?></span>
                                        </span>
                                    </div>

                                    <?php if (strtolower($payment['provider']) == 'stripe') { ?>
                                        <div class="d-none">
                                            <a class="btn btn-light" href="<?php echo $this->url('my/billing/payments?provider=stripe&token=' . $this->token); ?>" target="_blank">Change payment method</a>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    No payment method added yet
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center justify-content-lg-start mb-4">
                    <div class="col-md-8 col-lg-8 col-xl-7 offset-lg-1">
                        <div class="card border-0 p-3">
                            <h5 class="fw-bold mb-3">Billing address</h5>
                            <div class="mb-3">
                                <?php if (!empty($user['billing_address'])) { ?>
                                    <?php echo $user['name']; ?><br>
                                    <?php echo $user['billing_address']; ?><br>
                                    <?php echo $user['billing_city']; ?><br>
                                    <?php echo $user['billing_state']; ?><br>
                                    <?php echo $user['billing_country']; ?><br>
                                    <?php echo $user['billing_postal']; ?><br>
                                <?php } ?>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#billing_address"><?php echo empty($user['billing_address']) ? 'Add billing address' : 'Change billing address'; ?></button>
                            </div>
                            <div class="modal modal-sm" id="billing_address" tabindex="-1" aria-labelledby="billing address" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Billing address</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" class="form" novalidate>
                                                <div class="mb-3">
                                                    <input type="text" name="billing-address" class="form-control" id="address-input" minlength="2" placeholder="Address" value="<?php echo $user['billing_address']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" name="billing-city" class="form-control" id="city-input" minlength="2" placeholder="City" value="<?php echo $user['billing_city']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" name="billing-state" class="form-control" id="state-input" minlength="2" placeholder="State" value="<?php echo $user['billing_state']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" name="billing-country" class="form-control" id="country-input" minlength="2" placeholder="Country" value="<?php echo $user['billing_country']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" name="billing-postal-code" class="form-control" id="postal-input" minlength="2" placeholder="Postal code" value="<?php echo $user['billing_postal']; ?>" required>
                                                </div>
                                                <div class="py-2">
                                                    <button type="submit" class="btn btn-primary w-100" data-loader="Updating...">Update details</button>
                                                </div>
                                            </form>
                                        </div>
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