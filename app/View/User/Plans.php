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
                <div class="col-12 mx-auto" style="max-width: 1280px">
                    <?php if (!empty($plan)) { ?>
                        <div class="row justify-content-center mb-5">
                            <div class="col-md-8 col-lg-6 col-xl-4">
                                <div class="card border-0 p-3 shadow">
                                    <form method="post" class="form">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="fw-bold"></h5>
                                            <button type="button" class="btn-close" aria-label="Close" onclick="window.location.href='<?php echo $this->url('my/plans'); ?>'"></button>
                                        </div>
                                        <?php if ($flash = $this->flash()) { ?>
                                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                                        <?php } ?>
                                        <h6 class="mb-2 fw-semibold">Payment summary</h6>
                                        <div class="py-3 mb-4">
                                            <div class="d-flex justify-content-between mb-1">
                                                <div>Plan: <span class="notranslate"><?php echo $plan['name']; ?></span></div>
                                                <div class="notranslate"><?php echo $this->price($plan['price']); ?></div>
                                            </div>
                                            <hr>
                                            <?php if ($tax != 0) { ?>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <div>Subtotal</div>
                                                    <div class="notranslate"><?php echo $this->price($subtotal); ?></div>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <div>Tax <?php echo isset($setting['tax']) ? "($setting[tax]%)" : null; ?></div>
                                                    <div class="notranslate"><?php echo $this->price($tax); ?></div>
                                                </div>
                                            <?php } ?>
                                            <div class="d-flex justify-content-between fw-bold mt-2">
                                                <div>Total (<?php echo ($this->setting['currency']); ?>)</div>
                                                <div class="notranslate"><?php echo $this->price($total_amount); ?></div>
                                            </div>
                                        </div>
                                        <?php if ($total_amount == 0) { ?>
                                            <div class="my-4">
                                                <input type="hidden" name="payment_method" value="system">
                                                <button type="submit" class="btn btn-primary fw-bold w-100" data-loader="">Subscribe</button>
                                            </div>
                                        <?php } else { ?>
                                            <h6 class="mb-2 fw-semibold">Payment method</h6>
                                            <div class="list-group mb-3 border-0">
                                                <?php foreach ($payments as $key => $payment) { ?>
                                                    <label class="list-group-item radio d-flex justify-content-between align-items-center py-3 border-0 border-bottom" for="i-<?php echo $payment['provider']; ?>">
                                                        <span class="d-flex align-items-center">
                                                            <img width="32" height="32" src="<?php echo $this->url('assets/img/payment/' . strtolower($payment['provider']) . '.png'); ?>">
                                                            <span class="px-3">
                                                                <span class="fw-bold d-block notranslate"><?php echo $payment['name']; ?></span>
                                                            </span>
                                                        </span>
                                                        <input type="radio" name="payment_method" class="form-check-input" id="i-<?php echo $payment['provider']; ?>" value="<?php echo $payment['provider']; ?>" <?php echo $user['payment_method'] == $payment['provider'] ? 'checked' : ($key == 0 ? 'checked' : null); ?> required>
                                                    </label>
                                                <?php } ?>
                                                <?php if (!empty($setting['offline_payment'])) { ?>
                                                    <label class="list-group-item radio d-flex justify-content-between align-items-center py-3 border-0" for="i-offline-payment">
                                                        <span class="d-flex">
                                                            <span class="text-center" style="width: 32px; height: 32px;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                                                                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                                                                    <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z" />
                                                                </svg>
                                                            </span>
                                                            <span class="px-3">
                                                                <span class="fw-bold d-block"><?php echo $setting['offline_payment_title']; ?></span>
                                                            </span>
                                                        </span>
                                                        <input type="radio" name="payment_method" class="form-check-input" id="i-offline-payment" value="offline_payment" required>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                            <div class="my-4">
                                                <button type="submit" class="btn btn-lg btn-primary fw-bold w-100" data-loader="">Pay now</button>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="mb-5" id="pricing">
                            <?php if ($flash = $this->flash()) { ?>
                                <div class="text-center fs-6 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                            <?php } ?>
                            <div class="text-center mb-5">
                                <div class="display-6 fw-bold mb-3">Plans & Pricing</div>
                            </div>
                            <?php if (!empty($plans) && count($plans) > 1) { ?>
                                <div class="nav mb-5">
                                    <div class="d-flex mx-auto" id="pricing-tab" role="tablist">
                                        <button class="nav-link rounded active" data-bs-toggle="pill" data-bs-target="#tab-month" type="button" role="tab" aria-controls="tab-month" aria-selected="true">Monthly</button>
                                        <?php if (!empty($plans['year'])) { ?>
                                            <button class="nav-link rounded" data-bs-toggle="pill" data-bs-target="#tab-year" type="button" role="tab" aria-controls="tab-year" aria-selected="false">Yearly</button>
                                        <?php } ?>
                                        <?php if (!empty($plans['lifetime'])) { ?>
                                            <button class="nav-link rounded" data-bs-toggle="pill" data-bs-target="#tab-lifetime" type="button" role="tab" aria-controls="tab-lifetime" aria-selected="false">Lifetime</button>
                                        <?php } ?>
                                        <?php if (!empty($plans['prepaid'])) { ?>
                                            <button class="nav-link rounded" data-bs-toggle="pill" data-bs-target="#tab-prepaid" type="button" role="tab" aria-controls="tab-prepaid" aria-selected="false">Prepaid</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="tab-content mb-5" id="pills-tabContent">
                                <?php foreach ($plans as $key => $results) { ?>
                                    <div class="tab-pane <?php echo $key == 'month' ? 'show active' : null; ?>" id="tab-<?php echo $key; ?>" role="tabpanel" tabindex="0">
                                        <div class="row g-3 justify-content-center">
                                            <?php foreach ($results as $plan) {
                                                $description = !empty($plan['description']) ? explode(PHP_EOL, $plan['description']) : []; ?>
                                                <div class="col-12 col-md-6 col-xxl-3">
                                                    <div class="card h-100 shadow-sm border <?php echo !empty($plan['highlight']) ? 'border-warning' : null; ?>">
                                                        <?php if (!empty($plan['highlight'])) { ?>
                                                            <div class="position-absolute w-100 text-center text-black p-2 fw-bold" style="background-color: #f7d700; border-top-right-radius: 5px; border-top-left-radius: 5px;">Most Popular</div>
                                                        <?php } ?>
                                                        <div class="card-body text-center">
                                                            <div class="my-5">
                                                                <div class="h5 fw-bold mb-2 notranslate"><?php echo $plan['name']; ?></div>
                                                                <div class="mb-4"><?php echo isset($plan['title_' . $this->setting['language']]) ? $plan['title_' . $this->setting['language']] : $plan['title']; ?></div>
                                                                <div class="mb-4">
                                                                    <div class="fw-bold h2 mb-0 notranslate"><?php echo $this->price($plan['price']); ?></div>
                                                                    <div class="text-muted"><?php echo $plan['duration'] == 'month' ? "Per Month" : ($plan['duration'] == 'year' ? "Per Year" : "One Time Payment"); ?></div>
                                                                </div>
                                                                <div>
                                                                    <?php if (isset($this->user['plan_id']) && $this->user['plan_id'] == $plan['id'] && isset($user['subscription_status']) && $user['subscription_status'] == 1) { ?>
                                                                        <button type="button" class="btn btn-lg btn-light btn-outline-secondary w-100 mb-1 fw-semibold" disabled>Subscribed</button>
                                                                    <?php } else if ($setting['free_plan'] == $plan['id'] && $plan['price'] == 0) { ?>
                                                                        <button type="button" class="btn btn-lg btn-primary fw-semibold w-100 mb-1" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                                                            <?php echo $plan['duration'] == 'prepaid' ? 'Buy now' : 'Subscribe'; ?>
                                                                        </button>
                                                                        <div class="modal modal-sm fade" id="confirmModal" tabindex="-1" aria-labelledby="confirm plan" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5">Confirm</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body text-center">
                                                                                        <p class="mb-4 h6 fw-bold">Are you sure you want to activate this plan?</p>
                                                                                        <div class="py-2">
                                                                                            <button type="submit" class="btn btn-lg btn-primary fw-semibold btn-spinner w-100" id="submitButton" data-loader="" onclick="window.location.href='<?php echo $this->url('my/plans?id=' . $plan['id'] . ''); ?>'">Active</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } else { ?>
                                                                        <button type="button" class="btn btn-lg btn-primary fw-semibold btn-spinner w-100 mb-1" onclick="window.location.href='<?php echo $this->url('my/plans?id=' . $plan['id'] . ''); ?>'">
                                                                            <?php echo $plan['duration'] == 'prepaid' ? 'Buy now' : 'Subscribe'; ?>
                                                                        </button>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php if (!empty($description)) { ?>
                                                                    <div class="text-start my-4">
                                                                        <?php foreach ($description as $val) { ?>
                                                                            <div class="mb-3">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                                                                </svg><span class="ms-2"><?php echo $val; ?></span>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row justify-content-center py-5 mb-5">
                            <div class="col-lg-9">
                                <h2 class="fw-bold mb-5 text-center">Frequently Asked Questions</h2>
                                <hr>
                                <div class="accordion accordion-flush" id="faq">
                                    <div class="accordion-item bg-transparent py-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed shadow-none bg-transparent fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false">
                                                Can I change my subscription plan later?
                                            </button>
                                        </h2>
                                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faq">
                                            <div class="accordion-body pt-0">
                                                Yes, you can upgrade to the next level of your business anytime. See your plan details in the plan section any time.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item bg-transparent py-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed shadow-none bg-transparent fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false">
                                                Can I cancel my subscription anytime?
                                            </button>
                                        </h2>
                                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faq">
                                            <div class="accordion-body pt-0">
                                                Yes, you can cancel your subscription at any time. Please beware that your data or connections may not be available.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item bg-transparent py-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed shadow-none bg-transparent fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false">
                                                What happens if I miss a payment?
                                            </button>
                                        </h2>
                                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faq">
                                            <div class="accordion-body pt-0">
                                                If you miss a payment, your subscription may be suspended (for 30 days) and then cancelled after that. But you can re-subscribe any time.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item bg-transparent py-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed shadow-none bg-transparent fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false">
                                                Is there any hidden fees with subscription plans?
                                            </button>
                                        </h2>
                                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faq">
                                            <div class="accordion-body pt-0">
                                                Not at all, our subscription pricing plans are transparent and do not have any hidden fees. The cost you pay is what you see on the pricing plan and your dashboard.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>