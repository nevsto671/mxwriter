<!doctype html>
<html lang="<?php echo $this->setting['direction'] == 'rtl' ? 'ar' : 'en'; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
    <?php require_once APP . '/View/User/Head.php'; ?>
</head>

<body>
    <?php require_once APP . '/View/Admin/Header.php'; ?>
    <main>
        <div class="container-fluid">
            <?php require_once APP . '/View/Admin/Sidebar.php'; ?>
            <div class="main">
                <h2 class="fw-bold mb-4">Transactions</h2>
                <div class="card border-0 p-3 mb-4">
                    <h5 class="fw-bold mb-2">Revenue</h5>
                    <p>Below you'll find current month summary of earning per day except tax. All dates and times are UTC-based.</p>
                    <div id="chart"></div>
                </div>
                <div class="card border-0 p-3">
                    <div class="d-sm-flex justify-content-between mb-3 mb-sm-0">
                        <h5 class="fw-bold mb-3">Transaction history</h5>
                    </div>
                    <?php if ($transactions) { ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">User name</th>
                                        <th scope="col" class="d-none d-sm-table-cell">Date</th>
                                        <th scope="col" class="d-none d-sm-table-cell">Trx ID</th>
                                        <th scope="col" class="d-none d-sm-table-cell">Method</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col" class="text-end" style="width: 80px">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $transaction) { ?>
                                        <tr>
                                            <td><a class="text-dark text-decoration-none hover-blue notranslate" href="<?php echo $this->url("admin/users?id=$transaction[user_id]"); ?>" target="_blank"><?php echo isset($transaction['user_name']) ? $transaction['user_name'] : 'Unknown'; ?></a></td>
                                            <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'], strtotime($transaction['created'])); ?></td>
                                            <td class="d-none d-sm-table-cell notranslate"><?php echo $transaction['id']; ?></td>
                                            <td class="d-none d-sm-table-cell notranslate"><?php echo $transaction['method']; ?></td>
                                            <td class="notranslate"><?php echo $this->price($transaction['amount']); ?></td>
                                            <td class="text-end"><?php echo $transaction['payment_status'] == 2 ? '<span class="badge bg-warning text-dark">Pending</span>' : ($transaction['payment_status'] == 1 ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-danger">Canceled</span>'); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <nav class="mt-4"><?php echo $pagination; ?></nav>
                    <?php } else { ?>
                        <div>Transaction history not available!</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var data = <?php echo json_encode(array_values($data_arr)); ?>;
        var options = {
            series: [{
                name: 'Amount',
                data: data,
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    datetimeUTC: false
                }
            },
            tooltip: {
                x: {
                    format: 'dd MMM yyyy'
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
</body>

</html>