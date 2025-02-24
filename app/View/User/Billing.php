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
                    <div class="col-12 col-xl-9 offset-xl-1">
                        <div class="d-sm-flex justify-content-between mb-4">
                            <h2 class="fw-bold mb-3 mb-sm-0">Billing overview</h2>
                            <div>
                                <a class="btn btn-light me-2" href="<?php echo $this->url('my/plans'); ?>">Upgrade plan</a>
                            </div>
                        </div>
                        <div class="card border-0 p-3 p-xl-4">
                            <?php if ($flash = $this->flash()) { ?>
                                <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                            <?php } ?>
                            <?php if (isset($user['subscription_status']) && $user['subscription_status'] == 2) { ?>
                                <div class="p-2 alert alert-warning mb-4">We received your subscription cancellation request. Your subscription will automatically be canceled at the end of the current period.</div>
                            <?php } ?>
                            <div class="row g-3 mb-5">
                                <div class="col-12 col-md-3 col-md-auto">
                                    <div class="card py-3 px-3 h-100 shadow">
                                        <div class="fw-bold text-muted">Active plan</div>
                                        <div class="notranslate"><?php echo $plan_name; ?></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-md-auto">
                                    <div class="card py-3 px-3 h-100 shadow">
                                        <div class="fw-bold text-muted">Plan expire</div>
                                        <div><?php echo !empty($expired) ? $expired : 'No'; ?></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-md-auto">
                                    <div class="card py-3 px-3 h-100 shadow">
                                        <div class="fw-bold text-muted">Words left</div>
                                        <div><?php echo is_null($remaining_words) ? 'Unlimited' : $remaining_words; ?> words</div>
                                    </div>
                                </div>
                                <?php if ($this->setting['image_status']) { ?>
                                    <div class="col-12 col-md-3 col-md-auto">
                                        <div class="card py-3 px-3 h-100 shadow">
                                            <div class="fw-bold text-muted">Images left</div>
                                            <div><?php echo is_null($remaining_images) ? 'Unlimited' : $remaining_images; ?> Images</div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-5 px-2">
                                <div class="row gy-5">
                                    <div class="col-sm-6">
                                        <a class="d-flex text-dark text-decoration-none hover-dark" href="<?php echo $this->url('my/billing/payments'); ?>">
                                            <div class="d-flex justify-content-center align-items-center me-3 text-white rounded" style="width: 48px; height: 48px; background-color: #38d983;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h6 class="my-1 fw-bold">Payment methods</h6>
                                                <div class="small text-muted">Add or change payment method</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a class="d-flex text-dark text-decoration-none hover-dark" href="<?php echo $this->url('my/plans'); ?>">
                                            <div class="d-flex justify-content-center align-items-center me-3 text-white rounded" style="width: 48px; height: 48px; background-color: #f7ae60;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                                                    <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h6 class="my-1 fw-bold">Plans and pricing</h6>
                                                <div class="small text-muted">View pricing and FAQs</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a class="d-flex text-dark text-decoration-none hover-dark" href="<?php echo $this->url('my/billing/subscriptions'); ?>">
                                            <div class="d-flex justify-content-center align-items-center me-3 text-white rounded" style="width: 48px; height: 48px; background-color: #6e58e8;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                                                    <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z" />
                                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h6 class="my-1 fw-bold">Subscription history</h6>
                                                <div class="small text-muted">View subscriptions and invoices</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a class="d-flex text-dark text-decoration-none hover-dark" href="<?php echo $this->url('my/billing/transactions'); ?>">
                                            <div class="d-flex justify-content-center align-items-center me-3 text-white rounded" style="width: 48px; height: 48px; background-color: #d757d9;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-credit-card-2-front" viewBox="0 0 16 16">
                                                    <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z" />
                                                    <path d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h6 class="my-1 fw-bold">Transaction history</h6>
                                                <div class="small text-muted">View payment transactions</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php if ($user['plan_id'] != 0 && $setting['free_plan'] != $user['plan_id'] && $user['subscription_status'] == 1) { ?>
                                <div>
                                    <p>Your subscriptions will automatically renew at the end of your current service period. If you do not want to renew then cancel your subscription before end of the period.</p>
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#cancel_subscription">Cancel subscription</button>
                                    <div class="modal modal-sm fade" id="cancel_subscription" tabindex="-1" aria-labelledby="cancel plan" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">Cancel subscription</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p class="mb-3">If you cancel your subscription, you can continue to use the plan benefits and remaining credits until the end of your current subscription period. You can also resubscribe at any time.</p>
                                                    <div class="form-check form-check-inline mb-3">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox">
                                                        <?php if ($this->setting['frontend_status']) { ?>
                                                            <label class="form-check-label" for="inlineCheckbox">I agree to the <a class="text-decoration-none" href="<?php echo $this->url('terms'); ?>" target="_blank">Terms of Use</a></label>
                                                        <?php } else { ?>
                                                            <label class="form-check-label" for="inlineCheckbox">I agree to the Terms of Use</label>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="py-2">
                                                        <form method="post" class="form">
                                                            <input type="hidden" name="cancelSubscription" value="<?php echo $this->token; ?>">
                                                            <button type="submit" class="btn btn-danger px-4" id="submitButton" data-loader="" disabled>Cancel subscription</button>
                                                        </form>
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
                <?php if (!empty($pending_subscriptions)) { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-12 col-xl-9 offset-xl-1">
                            <div class="card border-0 p-3">
                                <h5 class="fw-bold mb-3">Pending plans</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Invoice</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Plan name</th>
                                                <th scope="col" class="d-none d-sm-table-cell">Created</th>
                                                <th scope="col" class="text-end d-none d-sm-table-cell">Status</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pending_subscriptions as $subscription) { ?>
                                                <tr>
                                                    <td>#<?php echo $subscription['id']; ?></td>
                                                    <td><?php echo $this->price($subscription['amount']); ?></td>
                                                    <td><?php echo isset($subscription['plan_name']) ? $subscription['plan_name'] : 'Unknown'; ?></td>
                                                    <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'] . ' ' . $this->setting['time_format'], strtotime($subscription['start'])); ?></td>
                                                    <td class="text-end d-none d-sm-table-cell"><span class="badge bg-warning text-dark">Pending</span></td>
                                                    <td class="text-end"><a class="text-decoration-none" href="<?php echo $this->url("my/billing/subscriptions?id=$subscription[id]"); ?>">View</a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('inlineCheckbox');
            const submitButton = document.getElementById('submitButton');
            checkbox.addEventListener('change', function() {
                submitButton.disabled = !checkbox.checked;
            });
        });
    </script>
</body>

</html>