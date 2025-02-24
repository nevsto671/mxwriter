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
                <?php if (!empty($payout)) { ?>
                    <div class="col-12 mx-auto" style="max-width: 400px;">
                        <div class="card p-3">
                            <div class="d-flex justify-content-between mb-4">
                                <h5></h5>
                                <a class="btn btn-close" href="<?php echo $this->url('admin/affiliates'); ?>"></a>
                            </div>
                            <div class="p-4">
                                <div class="mb-5 text-center">
                                    <h1 class="fw-bold notranslate"><?php echo $this->price($payout['amount']); ?></h1>
                                    <small>Total Amount</small>
                                </div>
                                <div class="mb-5">
                                    <h6 class="fw-bold mb-3">Payout Address:</h6>
                                    <p class="notranslate"><?php echo !empty($payout['address']) ?  nl2br($payout['address']) : 'Not found'; ?></p>
                                </div>
                            </div>
                            <div class="row g-3">
                                <?php if ($payout['status'] == 2) { ?>
                                    <div class="col">
                                        <a class="btn btn-primary w-100" href="<?php echo $this->url("admin/affiliates?payout=$payout[id]&status=approve"); ?>">Approve</a>
                                    </div>
                                    <div class="col">
                                        <a class="btn btn-danger w-100" href="<?php echo $this->url("admin/affiliates?payout=$payout[id]&status=declined"); ?>">Declined</a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-12 col-xl-11 col-xxl-10 mx-auto">
                        <?php if ($flash = $this->flash()) { ?>
                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                        <?php } ?>
                        <div class="mb-3">
                            <div class="row g-3 text-center">
                                <div class="col-12 col-sm-6 col-xl-3">
                                    <div class="card p-3 h-100">
                                        <h1 class="h3 fw-semibold notranslate"><?php echo $total_referral; ?></h1>
                                        <p class="mb-0">Total Referral</p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-3">
                                    <div class="card p-3 h-100">
                                        <h1 class="h3 fw-semibold notranslate"><?php echo $this->price($total_transaction_amount); ?></h1>
                                        <p class="mb-0">Referral Earning</p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-3">
                                    <div class="card p-3 h-100">
                                        <h1 class="h3 fw-semibold notranslate"><?php echo $this->price($total_payout_amount); ?></h1>
                                        <p class="mb-0">Total Payout</p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-3">
                                    <div class="card p-3 h-100">
                                        <h1 class="h3 fw-semibold notranslate"><?php echo $this->price($total_payout_pending); ?></h1>
                                        <p class="mb-0">Pending</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card p-3 mb-3">
                            <h6 class="fw-bold">Payouts</h6>
                            <?php if (!empty($payouts)) { ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" class="text-end" style="width: 80px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($payouts as $payout) { ?>
                                                <tr>
                                                    <td><?php echo date($this->setting['date_format'], strtotime($payout['created'])); ?></td>
                                                    <td class="notranslate"><?php echo $this->setting['currency_position'] == 'right' ? $payout['amount'] . $this->setting['currency_symbol'] : $this->setting['currency_symbol'] . $payout['amount']; ?></td>
                                                    <td>
                                                        <?php if ($payout['status'] == 0) { ?>
                                                            <span class="badge bg-danger">Cancel</span>
                                                        <?php } else if ($payout['status'] == 1) { ?>
                                                            <span class="badge bg-success">Completed</span>
                                                        <?php } else if ($payout['status'] == 2) { ?>
                                                            <span class="badge bg-warning text-black">Pending</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-end">
                                                        <a class="btn btn-sm btn-light" href="<?php echo $this->url('admin/affiliates?payout=' . $payout['id']); ?>">View</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <nav class=""><?php echo $payout_pagination; ?></nav>
                            <?php } else { ?>
                                <div class="my-5 text-center">
                                    <h4 class="mb-3">You don't have any payouts yet.</h4>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="card p-3 mb-3">
                            <h6 class="fw-bold">Referrals</h6>
                            <?php if (!empty($referrals)) { ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Invites</th>
                                                <th scope="col">Earnings</th>
                                                <th scope="col" class="d-none d-sm-table-cell">Date purchased</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" class="text-end" style="width: 80px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($referrals as $referral) { ?>
                                                <tr>
                                                    <td class="notranslate"><?php echo !empty($referral['name']) ? $referral['name'] : 'Unknown'; ?></td>
                                                    <td class="notranslate"><?php echo $this->setting['currency_position'] == 'right' ? $referral['earnings'] . $this->setting['currency_symbol'] : $this->setting['currency_symbol'] . $referral['earnings']; ?></td>
                                                    <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'], strtotime($referral['created'])); ?></td>
                                                    <td>
                                                        <?php if ($referral['status'] == 0) { ?>
                                                            <span class="badge bg-danger">Declined</span>
                                                        <?php } else if ($referral['status'] == 1) { ?>
                                                            <span class="badge bg-success">Completed</span>
                                                        <?php } else if ($referral['status'] == 2) { ?>
                                                            <span class="badge bg-warning text-black">Pending</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-end">
                                                        <?php if ($referral['status'] == 2) { ?>
                                                            <a class="btn btn-sm btn-danger" href="<?php echo $this->url("admin/affiliates?referral=$referral[id]&status=declined"); ?>">Declined</a>
                                                        <?php } else { ?>
                                                            -
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <nav class=""><?php echo $pagination; ?></nav>
                            <?php } else { ?>
                                <div class="my-5 text-center">
                                    <h4 class="mb-3">You haven't made any referrals yet</h4>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="modal fade" id="withdrawal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered z-3">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Withdrawal</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" class="form" novalidate>
                                            <div class="mb-4">
                                                <label class="form-label text-muted">Chat title</label>
                                                <input type="text" name="name" class="form-control" minlength="3" maxlength="200" placeholder="e.g. New chat" required>
                                            </div>
                                            <div class="py-2">
                                                <button type="submit" class="btn btn-primary w-100" data-loader="">Save</button>
                                            </div>
                                        </form>
                                    </div>
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