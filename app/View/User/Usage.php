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
            <div class="card border-0 p-3">
              <h5 class="fw-bold mb-3">Usage</h5>
              <p>Below you'll find a summary of word usage per day. All dates and times are UTC-based.</p>
              <div id="chart"></div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center justify-content-lg-start mb-4">
          <div class="col-12 col-xl-9 offset-xl-1">
            <div class="card border-0 p-3">
              <h5 class="fw-bold mb-3">Active plan: <?php echo $plan_name; ?></h5>
              <p class="mb-3">Words generated in this month: <?php echo $usage_words; ?> (<?php echo $usage_percentage; ?>%).</p>
              <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?php echo $usage_percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="height: 18px">
                <div class="progress-bar" style="width: <?php echo $usage_percentage; ?>%"><?php echo $usage_percentage; ?>%</div>
              </div>
              <?php if (!empty($user['expired'])) { ?>
                <p class="mt-3 mb-0">Credits will reset on: <?php echo date($this->setting['date_format'] . ' ' . $this->setting['time_format'], strtotime($user['expired'])); ?></p>
              <?php } ?>
            </div>
          </div>
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
</body>

</html>