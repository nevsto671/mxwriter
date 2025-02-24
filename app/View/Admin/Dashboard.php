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
        <div class="mb-4">
          <h2 class="fw-bold mb-4">Overview</h2>
          <div class="row g-4">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold text-muted">Words Generated</h6>
                <h6 class="fw-bold mb-0"><?php echo $total_words_generated; ?> words</h6>
              </div>
            </div>
            <?php if ($this->setting['image_status']) { ?>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm p-3 h-100">
                  <h6 class="fw-bold text-muted">Images Generated</h6>
                  <h6 class="fw-bold mb-0"><?php echo $total_images_generated; ?> images</h6>
                </div>
              </div>
            <?php } ?>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold text-muted">Total Earning</h6>
                <h6 class="fw-bold mb-0"><?php echo $this->setting['currency_symbol'] . $total_earning . ' ' . $this->setting['currency']; ?></h6>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold text-muted">Total Subscriber</h6>
                <h6 class="fw-bold mb-0"><?php echo $total_subscriber; ?> subscriber</h6>
              </div>
            </div>
          </div>
        </div>
        <div class="card border-0 p-3 mb-4">
          <h5 class="fw-bold mb-2">Usage</h5>
          <p>Below you'll find current month summary of word usage per day. All dates and times are UTC-based.</p>
          <div id="chart"></div>
        </div>
        <?php if (!empty($pending_subscriptions)) { ?>
          <div class="mb-4" id="pending">
            <div class="card border-0 p-3">
              <div class="d-sm-flex justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <h5 class="fw-bold mb-3 mb-sm-0">Pending subscriptions</h5>
                </div>
                <div>
                  <form method="get" action="<?php echo $this->url("admin"); ?>">
                    <div class="input-group border rounded">
                      <input type="text" name="pending" class="form-control border-0 shadow-none" value="<?php echo isset($_REQUEST['pending']) ? $_REQUEST['pending'] : null; ?>" placeholder="Invoice number" aria-label="invoice">
                      <button class="btn btn-sm btn-light" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <?php if ($flash = $this->flash()) { ?>
                <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
              <?php } ?>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Invoice</th>
                      <th scope="col" class="d-none d-sm-table-cell">Method</th>
                      <th scope="col">Amount</th>
                      <th scope="col">Plan</th>
                      <th scope="col" class="d-none d-sm-table-cell">Created</th>
                      <th scope="col" class="d-none d-sm-table-cell">User</th>
                      <th scope="col" class="text-end" style="width: 50px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pending_subscriptions as $subscription) { ?>
                      <tr>
                        <td class="notranslate">#<?php echo $subscription['id']; ?></td>
                        <td class="notranslate"><?php echo $subscription['method']; ?></td>
                        <td><?php echo $this->price($subscription['amount']); ?></td>
                        <td class="notranslate"><?php echo isset($subscription['plan_name']) ? $subscription['plan_name'] : 'Unknown'; ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'] . ' ' . $this->setting['time_format'], strtotime($subscription['start'])); ?></td>
                        <td class="d-none d-sm-table-cell"><a class="text-dark text-decoration-none hover-blue" href="<?php echo $this->url("admin/users?id=$subscription[user_id]"); ?>" target="_blank"><?php echo isset($subscription['user_name']) ? $subscription['user_name'] : 'Unknown'; ?></a></td>
                        <td class="text-end">
                          <button type="button" class="btn btn-sm btn-success" onclick="if (confirm('Are you sure you want to active #<?php echo $subscription['id']; ?> subscription?')) window.location.href='<?php echo $this->url('admin?subscriptions_pending&invoice=' . $subscription['id'] . '&sign=' . md5($subscription['id'])); ?>';">Approve</button>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <nav><?php echo $pagination; ?></nav>
            </div>
          </div>
        <?php } else if (!empty($_GET['pending'])) { ?>
          <div class="card border-0 p-3">
            <div class="d-flex justify-content-between">
              <div>
                No pending subscriptions
              </div>
              <div>
                <a class="btn btn-sm btn-light" href="<?php echo $this->url("admin#pending"); ?>">View all</a>
              </div>
            </div>
          </div>
        <?php } ?>
        <?php if (!empty($recent_subscriptions)) { ?>
          <div class="mb-4" id="pending">
            <div class="card border-0 p-3">
              <div class="d-sm-flex justify-content-between mb-4">
                <h5 class="fw-bold mb-3 mb-sm-0">Recent subscriptions</h5>
                <div>
                  <a class="btn btn-sm btn-light" href="<?php echo $this->url("admin/subscriptions"); ?>">View all</a>
                </div>
              </div>
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
                    <?php foreach ($recent_subscriptions as $subscription) { ?>
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
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </main>
  <?php require_once APP . '/View/User/Tail.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    var data = <?php echo json_encode(array_values($data_arr)); ?>;
    var options = {
      series: [{
        name: 'Words',
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
  </script>
</body>

</html>