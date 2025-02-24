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
                <?php if (!isset($_GET['search'])) { ?>
                    <h2 class="fw-bold mb-4">Subscriptions</h2>
                    <div class="card border-0 p-3 mb-4">
                        <h5 class="fw-bold mb-2">Summary</h5>
                        <p>Below you'll find current month summary of subscription per day. All dates and times are UTC-based.</p>
                        <div id="chart"></div>
                    </div>
                <?php } ?>
                <div class="card border-0 p-3">
                    <div class="d-md-flex justify-content-between">
                        <h5 class="fw-bold mb-3">Subscription <span class="d-none d-md-inline">history</span></h5>
                        <div class="d-flex mb-2 mb-md-0">
                            <div class="me-2">
                                <form method="get" action="<?php echo $this->url("admin/subscriptions"); ?>">
                                    <div class="input-group border rounded">
                                        <input type="text" name="search" class="form-control py-0 border-0 shadow-none" value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search'] : null; ?>" placeholder="Search...">
                                        <button type="submit" class="btn border-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#999" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="me-2">
                                <div class="dropdown">
                                    <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end px-2 py-0" style="min-width: auto;">
                                        <li><a class="dropdown-item py-1" href="<?php echo $this->url("admin/subscriptions?search&plan=all"); ?>">All plan</a></li>
                                        <?php foreach ($plans as $plan) {
                                            if ($plan['duration'] != 'prepaid') { ?>
                                                <li><a class="dropdown-item py-1" href="<?php echo $this->url("admin/subscriptions?search&plan=$plan[id]"); ?>"><?php echo $plan['name']; ?></a></li>
                                        <?php }
                                        } ?>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-sort">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 9l4 -4l4 4m-4 -4v14" />
                                            <path d="M21 15l-4 4l-4 -4m4 4v-14" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end px-2 py-0" style="min-width: auto;">
                                        <li><a class="dropdown-item py-1" href="<?php echo $this->url("admin/subscriptions?search&status=1"); ?>">Active</a></li>
                                        <li><a class="dropdown-item py-1" href="<?php echo $this->url("admin/subscriptions?search&status=2"); ?>">Pending</a></li>
                                        <li><a class="dropdown-item py-1" href="<?php echo $this->url("admin/subscriptions?search&status=0"); ?>">Expired</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($subscriptions) { ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">User name</th>
                                        <th scope="col">Plan name</th>
                                        <th scope="col" class="d-none d-sm-table-cell">Subscribed</th>
                                        <th scope="col" class="d-none d-sm-table-cell">Expiry date</th>
                                        <th scope="col" class="text-end" style="width: 50px">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($subscriptions as $subscription) { ?>
                                        <tr>
                                            <td><a class="text-dark text-decoration-none hover-blue notranslate" href="<?php echo $this->url("admin/users?id=$subscription[user_id]"); ?>" target="_blank"><?php echo isset($subscription['user_name']) ? $subscription['user_name'] : 'Unknown'; ?></a></td>
                                            <td class="notranslate"><?php echo isset($subscription['plan_name']) ? $subscription['plan_name'] : 'Unknown'; ?></td>
                                            <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'], strtotime($subscription['start'])); ?></td>
                                            <td class="d-none d-sm-table-cell"><?php echo !is_null($subscription['end']) ? date($this->setting['date_format'], strtotime($subscription['end'])) : '-'; ?></td>
                                            <td class="text-end"><?php echo $subscription['status'] == 2 ? '<span class="badge bg-warning text-dark">Pending</span>' : ($subscription['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Expired</span>'); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (empty($_GET['search'])) { ?>
                            <div class="d-flex justify-content-between">
                                <nav><?php echo $pagination; ?></nav>
                                <div class="py-2">Total: <?php echo $total; ?></div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div>Subscription not available!</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var data = <?php echo isset($data_arr) ? json_encode(array_values($data_arr)) : '[]'; ?>;
        var options = {
            series: [{
                name: 'Total plan',
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