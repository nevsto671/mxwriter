<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
  <?php require_once __DIR__ . '/Head.php'; ?>
</head>

<body>
  <?php require_once __DIR__ . '/Header.php'; ?>

  <main>
    <div class="section">
      <div class="container">
        <div class="text-center">
          <?php if (isset($_GET['success'])) { ?>
            <h2 class="mb-4 text-success fw-bold">Congratulations!</h2>
            <h4>Your payment has been successfully completed.</h4>
            <p>Thank you for choosing our services. We have received your payment and will process your order shortly.</p>
            <p>If you have any questions or concerns, please do not hesitate to contact us.</p>
          <?php } else if (isset($_GET['cancel'])) { ?>
            <h2 class="mb-4 text-danger fw-bold">Payment canceled!</h2>
            <p>We regret to inform you that your payment has been canceled.</p>
            <p>We apologize for any inconvenience this may have caused you.</p>
            <p>If you have any questions or concerns, please do not hesitate to contact us.</p>
          <?php } ?>
          <div class="my-5">
            <p>Please check your billing for further details of your order.</p>
            <a class="btn btn-primary" href="<?php echo $this->url("my/billing"); ?>">Go to billing page</a>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php require_once __DIR__ . '/Tail.php'; ?>
</body>

</html>