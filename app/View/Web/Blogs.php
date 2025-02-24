<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
  <?php require_once __DIR__ . '/Head.php'; ?>
</head>

<body>
  <?php require_once __DIR__ . '/Header.php'; ?>

  <main>
    <?php if ($results) { ?>
      <?php if ($slug && $blog) { ?>
        <div class="section text-center">
          <div class="container">
            <div class="mb-3"><?php echo date('M d, Y', strtotime($blog['created'])); ?></div>
            <h1 class="display-4 fw-bold m-0"><?php echo $blog['title']; ?></h1>
          </div>
        </div>
        <div class="container">
          <div class="col-xl-10 col-xxl-8 mx-auto py-5 fs-6">
            <?php echo $blog['description']; ?>
          </div>
        </div>
      <?php } else { ?>
        <div class="section text-center mb-5">
          <div class="display-5 fw-bold">Blog / News</div>
        </div>
        <div class="container">
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($results as $blog) { ?>
              <div class="col">
                <a class="card h-100 text-decoration-none shadow-sm" href="<?php echo $this->url("blog/$blog[slug]-" . base64_encode($blog['id'])); ?>">
                  <img src="<?php echo $blog['thumbnail'] ? $this->url($blog['thumbnail']) : 'data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA='; ?>" class="card-img-top" alt="">
                  <div class="card-body">
                    <div class="fw-semibold mb-2"><?php echo $blog['title']; ?></div>
                    <div class="small">Posted on <?php echo date('M d, Y', strtotime($blog['created'])); ?></div>
                  </div>
                </a>
              </div>
            <?php } ?>
          </div>
          <div class="pt-3 d-flex justify-content-center">
            <nav class="pagination-flush">
              <?php echo $pagination ?>
            </nav>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="section">
        <div class="container">
          <div class="text-center py-4">
            <div class="mb-5">
              <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z" />
                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z" />
              </svg>
            </div>
            <h4 class="fw-semibold mb-3">The post you are looking for is unavailable</h4>
          </div>
        </div>
      </div>
    <?php } ?>
  </main>
  <?php require_once __DIR__ . '/Tail.php'; ?>
</body>

</html>