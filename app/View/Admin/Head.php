<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo $this->setting['site_description']; ?>">
<meta name="author" content="Sohel Rana">
<meta name="csrf-token" content="<?php echo $this->token; ?>">
<title><?php echo $this->setting['site_title']; ?></title>
<base href="<?php echo $this->setting['site_url']; ?>">
<link rel="icon" type="image/png" href="<?php echo $this->url('assets/img/favicon.png'); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/bootstrap' . ($this->setting['direction'] == 'rtl' ? '.rtl' : null) . '.min.css'); ?>">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/app.css'); ?>">