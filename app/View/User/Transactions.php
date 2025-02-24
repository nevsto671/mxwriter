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
                        <?php if ($transactions) { ?>
                            <div class="card border-0 p-3">
                                <h5 class="fw-bold mb-3">Transactions history</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="d-none d-sm-table-cell">Method</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Date</th>
                                                <th scope="col" class="d-none d-sm-table-cell">Trx ID</th>
                                                <th scope="col" class="text-end" style="width: 80px">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($transactions as $transaction) { ?>
                                                <tr>
                                                    <td class="d-none d-sm-table-cell notranslate"><?php echo $transaction['method']; ?></td>
                                                    <td class="notranslate"><?php echo $this->price($transaction['amount']); ?></td>
                                                    <td><?php echo date($this->setting['date_format'], strtotime($transaction['created'])); ?></td>
                                                    <td class="d-none d-sm-table-cell notranslate"><?php echo $transaction['id']; ?></td>
                                                    <td class="text-end"><?php echo $transaction['payment_status'] == 2 ? '<span class="badge bg-warning text-dark">Pending</span>' : ($transaction['payment_status'] == 1 ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-danger">Canceled</span>'); ?></td>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-credit-card-2-front" viewBox="0 0 16 16">
                                            <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z" />
                                            <path d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                                        </svg>
                                    </div>
                                    <h5 class="fw-normal mb-5">Transaction history not available!</h5>
                                    <a class="btn btn-light" href="<?php echo $this->url("my/billing"); ?>">Go to billing</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>