<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
  <?php require_once __DIR__ . '/Head.php'; ?>
</head>

<body>
  <main>
    <div class="container">
      <div class="py-5">
        <div class="text-center py-5">
          <div class="mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-lightbulb-off" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.23 4.35A6.004 6.004 0 0 0 2 6c0 1.691.7 3.22 1.826 4.31.203.196.359.4.453.619l.762 1.769A.5.5 0 0 0 5.5 13a.5.5 0 0 0 0 1 .5.5 0 0 0 0 1l.224.447a1 1 0 0 0 .894.553h2.764a1 1 0 0 0 .894-.553L10.5 15a.5.5 0 0 0 0-1 .5.5 0 0 0 0-1 .5.5 0 0 0 .288-.091L9.878 12H5.83l-.632-1.467a2.954 2.954 0 0 0-.676-.941 4.984 4.984 0 0 1-1.455-4.405l-.837-.836zm1.588-2.653.708.707a5 5 0 0 1 7.07 7.07l.707.707a6 6 0 0 0-8.484-8.484zm-2.172-.051a.5.5 0 0 1 .708 0l12 12a.5.5 0 0 1-.708.708l-12-12a.5.5 0 0 1 0-.708z" />
            </svg>
          </div>
          <?php if (!empty($message)) {
            echo $message;
          } else { ?>
            <h4 class="mb-3">We are currently offline for maintenance</h4>
            Unfortunately the site is temporarily unavailable due to performing some maintenance at the moment. We will be back online shortly!
          <?php } ?>
        </div>
      </div>
    </div>
  </main>
</body>

</html>