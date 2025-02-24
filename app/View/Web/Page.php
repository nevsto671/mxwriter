<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
  <?php require_once __DIR__ . '/Head.php'; ?>
</head>

<body>
  <?php require_once __DIR__ . '/Header.php'; ?>

  <main>
    <div class="section text-center">
      <div class="container">
        <div class="display-5 fw-bold"><?php echo $page['title']; ?></div>
      </div>
    </div>
    <div class="container">
      <div class="col-xl-9 mx-auto py-5 mb-5">
        <?php echo $page['description']; ?>
      </div>
    </div>
  </main>
  <?php if ($this->setting['frontend_status']) require_once __DIR__ . '/Footer.php'; ?>
  <?php require_once __DIR__ . '/Tail.php'; ?>
</body>

</html>