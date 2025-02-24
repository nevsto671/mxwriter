<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo $this->setting['site_description']; ?>">
<meta name="csrf-token" content="<?php echo $this->token; ?>">
<meta property="og:title" content="<?php echo $this->setting['site_title']; ?>">
<meta property="og:type" content="website">
<meta property="og:description" content="<?php echo isset($this->setting['og_description']) ? $this->setting['og_description'] : $this->setting['site_description']; ?>">
<meta property="og:image" content="<?php echo isset($this->setting['og_image']) ? $this->setting['og_image'] : $this->url('assets/img/cover.jpg'); ?>">
<meta property="og:url" content="<?php echo isset($this->setting['og_url']) ? $this->setting['og_url'] : $this->url(null); ?>">
<title><?php echo $this->setting['site_title']; ?></title>
<base href="<?php echo $this->setting['site_url']; ?>">
<link rel="manifest" href="<?php echo $this->url('manifest.json'); ?>">
<link rel="icon" type="image/png" href="<?php echo $this->url('assets/img/favicon.png'); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/style.css'); ?>">