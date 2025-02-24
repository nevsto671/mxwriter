<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
    <?php require_once APP . '/View/User/Head.php'; ?>
    <style>
        #referral-tab button {
            border-bottom: 2px solid transparent;
        }

        #referral-tab button.active {
            border-bottom: 2px solid #999999;
        }
    </style>
</head>

<body>
    <?php require_once APP . '/View/User/Header.php'; ?>
    <main>
        <div class="container-fluid">
            <?php require_once APP . '/View/User/Sidebar.php'; ?>
            <div class="main">
                <?php if ($referral_id) { ?>
                    <div class="col-12 col-xl-11 col-xxl-10 mx-auto">
                        <div class="mb-2 d-flex justify-content-between d-none">
                            <h4 class="mb-2 fw-bold">Earn from referrals program</h4>
                            <div>
                                <button type="button" class="btn border">withdraw</button>
                            </div>
                        </div>

                        <div class="card border-0 p-3 p-xl-4  mb-4">
                            <div class="row gy-4 justify-content-between align-items-center">
                                <div class="col-12 col-md-6 text-center text-md-start">
                                    <div class="mb-2">
                                        <h4 class="mb-2 fw-bold">Share your referral link</h4>
                                        <p>Earn a <?php echo $setting['commission_rate']; ?>% commission from the first purchase.</p>
                                    </div>
                                    <div class="input-group mx-auto mx-md-0 rounded border" style="max-width: 375px;">
                                        <input type="text" class="form-control border-0 bg-transparent" id="referralLink" value="<?php echo $this->url("r/$referral_id"); ?>" readonly>
                                        <button type="button" class="btn border-0 btn-clipboard" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy to clipboard" data-copied-title="Copied!">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-clipboard" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path>
                                                <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check2" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="row g-3 text-center">
                                        <div class="col">
                                            <div>
                                                <h1 class="h3 fw-semibold"><?php echo isset($total) ? $total : 0; ?></h1>
                                                <p class="mb-0">Referred</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <h1 class="h3 fw-semibold"><?php echo $this->price($total_earning); ?></h1>
                                                <p class="mb-0">Earning</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <h1 class="h3 fw-semibold"><?php echo $this->price($balance); ?></h1>
                                                <p class="mb-0">Available</p>
                                                <button type="button" class="btn btn-link text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#Withdraw">withdraw</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card px-3">
                            <nav class="border-bottom mb-2">
                                <div class="nav" id="referral-tab" role="tablist">
                                    <button class="nav-link py-3 fw-semibold active" id="nav-referrals-tab" data-bs-toggle="tab" data-bs-target="#nav-referrals" type="button" role="tab" aria-controls="nav-referrals" aria-selected="true">Referrals</button>
                                    <button class="nav-link py-3 fw-semibold" id="nav-payouts-tab" data-bs-toggle="tab" data-bs-target="#nav-payouts" type="button" role="tab" aria-controls="nav-payouts" aria-selected="false">Payouts</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-referrals" role="tabpanel" aria-labelledby="nav-referrals-tab" tabindex="0">
                                    <?php if (!empty($referrals)) { ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Invites</th>
                                                        <th scope="col">Earnings</th>
                                                        <th scope="col" class="d-none d-sm-table-cell">Date purchased</th>
                                                        <th scope="col" class="text-end" style="width: 80px;">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($referrals as $referral) { ?>
                                                        <tr>
                                                            <td><?php echo !empty($referral['name']) ? $referral['name'] : 'Unknown'; ?></td>
                                                            <td><?php echo $this->setting['currency_position'] == 'right' ? $referral['earnings'] . $this->setting['currency_symbol'] : $this->setting['currency_symbol'] . $referral['earnings']; ?></td>
                                                            <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'], strtotime($referral['created'])); ?></td>
                                                            <td class="text-end">
                                                                <?php if ($referral['status'] == 0) { ?>
                                                                    <span class="badge bg-danger">Declined</span>
                                                                <?php } else if ($referral['status'] == 1) { ?>
                                                                    <span class="badge bg-success">Approved</span>
                                                                <?php } else if ($referral['status'] == 2) { ?>
                                                                    <span class="badge bg-warning text-black">Pending</span>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <nav class="my-4"><?php echo $pagination; ?></nav>
                                    <?php } else { ?>
                                        <div class="my-5 text-center">
                                            <h4 class="mb-5">You haven't made any referrals yet.</h4>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="tab-pane fade" id="nav-payouts" role="tabpanel" aria-labelledby="nav-payouts-tab" tabindex="0">
                                    <?php if (!empty($payouts)) { ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col" class="text-end" style="width: 0px;">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($payouts as $payout) { ?>
                                                        <tr>
                                                            <td><?php echo date($this->setting['date_format'], strtotime($payout['created'])); ?></td>
                                                            <td><?php echo $this->setting['currency_position'] == 'right' ? $payout['amount'] . $this->setting['currency_symbol'] : $this->setting['currency_symbol'] . $payout['amount']; ?></td>
                                                            <td class="text-end">
                                                                <?php if ($payout['status'] == 0) { ?>
                                                                    <span class="badge bg-danger">Cancel</span>
                                                                <?php } else if ($payout['status'] == 1) { ?>
                                                                    <span class="badge bg-success">Completed</span>
                                                                <?php } else if ($payout['status'] == 2) { ?>
                                                                    <span class="badge bg-warning text-black">Pending</span>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <nav class="my-4"><?php echo $payout_pagination; ?></nav>
                                    <?php } else { ?>
                                        <div class="my-5 text-center">
                                            <h4 class="mb-3">You don't have any payouts yet.</h4>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="Withdraw" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered z-3">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Withdrawal</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if ($balance > 0 && $balance >= $setting['minimum_payout']) { ?>
                                            <form method="post" class="form" novalidate>
                                                <div class="mb-4">
                                                    <label class="form-label text-muted">Enter your bank address</label>
                                                    <textarea name="address" class="form-control" rows="6" minlength="10" maxlength="200" placeholder="" required></textarea>
                                                </div>
                                                <div class="py-2">
                                                    <button type="submit" class="btn btn-primary w-100" data-loader="">Confirm and Withdraw</button>
                                                </div>
                                            </form>
                                        <?php } else { ?>
                                            <div class="py-3">
                                                <h6 class="fw-bold">Not available</h6>
                                                <p>Withdrawals are not available until earnings reach <?php echo !empty($setting['minimum_payout']) ? $this->price($setting['minimum_payout']) : null; ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-12 col-xl-11 col-xxl-10 mx-auto">
                        <div class="text-center">
                            <div class="my-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-affiliate">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5.931 6.936l1.275 4.249m5.607 5.609l4.251 1.275" />
                                    <path d="M11.683 12.317l5.759 -5.759" />
                                    <path d="M5.5 5.5m-1.5 0a1.5 1.5 0 1 0 3 0a1.5 1.5 0 1 0 -3 0" />
                                    <path d="M18.5 5.5m-1.5 0a1.5 1.5 0 1 0 3 0a1.5 1.5 0 1 0 -3 0" />
                                    <path d="M18.5 18.5m-1.5 0a1.5 1.5 0 1 0 3 0a1.5 1.5 0 1 0 -3 0" />
                                    <path d="M8.5 15.5m-4.5 0a4.5 4.5 0 1 0 9 0a4.5 4.5 0 1 0 -9 0" />
                                </svg>
                            </div>
                            <h3>Affiliate opportunities are not available.</h3>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
    <script>
        const clipboard = new ClipboardJS(".btn-clipboard", {
            target: e => e.closest(".card").querySelector("#referralLink"),
            text: e => e.closest(".card").querySelector("#referralLink")
        });
        clipboard.on('success', function(e) {
            var btn = $(e.trigger);
            var tooltip = bootstrap.Tooltip.getInstance(e.trigger);
            tooltip.setContent({
                '.tooltip-inner': btn.attr('data-copied-title')
            });
            document.getSelection().removeAllRanges();
            btn.find('.bi-clipboard').hide();
            btn.find('.bi-check2').show();
            setTimeout(function() {
                btn.find('.bi-check2').hide();
                btn.find('.bi-clipboard').show();
                tooltip.hide();
                tooltip.setContent({
                    '.tooltip-inner': btn.attr('data-bs-title')
                });
            }, 3000);
        });
        clipboard.on('error', function(e) {
            var btn = $(e.trigger);
            const tooltip = bootstrap.Tooltip.getInstance(e.trigger);
            tooltip.setContent({
                '.tooltip-inner': 'Not copied!'
            });
        });
    </script>
</body>

</html>