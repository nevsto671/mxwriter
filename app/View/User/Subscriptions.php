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
                <?php if (isset($_GET['id']) && !empty($subscription)) { ?>
                    <?php if ($flash = $this->flash()) { ?>
                        <div class="row justify-content-center justify-content-lg-start mb-4">
                            <div class="col-12 col-xl-9 offset-xl-1">
                                <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-12 col-xl-9 offset-xl-1">
                            <div class="card border-0 p-3">
                                <div class="d-flex justify-content-between">
                                    <h2 class="fw-bold"></h2>
                                    <button type="button" class="btn-close" aria-label="Close" onclick="javascript:location.href='<?php echo $this->url('my/billing/subscriptions'); ?>'"></button>
                                </div>
                                <div class="p-md-5">
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-1">
                                            <h4 class="fw-bold">Plan: <?php echo isset($subscription['plan_name']) ? $subscription['plan_name'] : 'Unknown'; ?></h4>
                                            <div class="ms-3"><?php echo $subscription['status'] == 2 ? '<span class="badge bg-warning text-dark">Pending</span>' : ($subscription['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Cancelled</span>'); ?></div>
                                        </div>
                                        <p><?php echo date($this->setting['date_format'], strtotime($subscription['start'])); ?> to <?php echo date($this->setting['date_format'], strtotime($subscription['end'])); ?></p>
                                    </div>
                                    <div>
                                        <div class="mb-4">
                                            <div class="fw-bold">Invoice Number: <span class="notranslate"><?php echo $subscription['id']; ?></span></div>
                                            <div>Total Amount: <span class="notranslate"><?php echo $this->price($subscription['amount']); ?></span></div>
                                            <div>Payment Method: <span class="notranslate"><?php echo $subscription['method']; ?></span></div>
                                        </div>
                                        <div>
                                            <?php if ($subscription['status'] != 0) { ?>
                                                <a class="btn btn-light mx-1" href="<?php echo $this->url("my/billing/subscriptions?print=$subscription[id]"); ?>" target="_blank">Print invoice</a>
                                                <a class="btn btn-light mx-1" href="<?php echo $this->url("my/billing/subscriptions?cancel=$subscription[id]&sign=" . md5($subscription['id'])); ?>" onclick="return confirm('Are you sure you want to cancel this plan?');">Cancel plan</a>
                                            <?php } ?>
                                        </div>
                                        <?php if ($subscription['offline_payment'] && $subscription['payment_status'] == 2) { ?>
                                            <div class="my-4">
                                                <hr>
                                                <div class="text-start">
                                                    <div class="mb-3">
                                                        <div class="mb-2 fw-bold">Guideline</div>
                                                        <?php echo $setting['offline_payment_guidelines']; ?>
                                                    </div>
                                                    <div>
                                                        <div class="mb-2 fw-bold">Recipient account</div>
                                                        <?php echo nl2br($setting['offline_payment_recipient']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-12 col-xl-9 offset-xl-1">
                            <?php if ($subscriptions) { ?>
                                <div class="card border-0 p-3">
                                    <h5 class="fw-bold mb-3">Subscription history</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Plan name</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Subscribed</th>
                                                    <th scope="col">Expiry date</th>
                                                    <th scope="col" class="text-end" style="width: 80px">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($subscriptions as $subscription) { ?>
                                                    <tr>
                                                        <td>
                                                            <a class="text-decoration-none text-dark hover-blue notranslate" href="<?php echo $this->url("my/billing/subscriptions?id=$subscription[id]"); ?>">
                                                                <?php echo isset($subscription['plan_name']) ? $subscription['plan_name'] : 'Unknown'; ?>
                                                            </a>
                                                        </td>
                                                        <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'], strtotime($subscription['start'])); ?></td>
                                                        <td><?php echo !is_null($subscription['end']) ? date($this->setting['date_format'], strtotime($subscription['end'])) : '-'; ?></td>
                                                        <td class="text-end"><?php echo $subscription['status'] == 2 ? '<span class="badge bg-warning text-dark">Pending</span>' : ($subscription['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Cancelled</span>'); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <nav class="my-4"><?php echo $pagination; ?></nav>
                            <?php } else { ?>
                                <div class="card border-0 p-3">
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                                                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z" />
                                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z" />
                                            </svg>
                                        </div>
                                        <h5 class="fw-normal mb-5">Subscription history not available!</h5>
                                        <a class="btn btn-light" href="<?php echo $this->url("my/billing"); ?>">Go to billing</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>