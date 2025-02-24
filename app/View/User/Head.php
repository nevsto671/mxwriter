<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo $this->setting['site_description']; ?>">
<meta name="csrf-token" content="<?php echo $this->token; ?>">
<title><?php echo $this->setting['site_title']; ?></title>
<base href="<?php echo $this->setting['site_url']; ?>">
<link rel="manifest" href="<?php echo $this->url('manifest.json'); ?>">
<link rel="icon" type="image/png" href="<?php echo $this->url('assets/img/favicon.png'); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/bootstrap' . ($this->setting['direction'] == 'rtl' ? '.rtl' : null) . '.min.css'); ?>">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/quill.min.css'); ?>">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/prism.min.css'); ?>">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/markdown.css'); ?>">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/simplebar.css'); ?>">
<link rel="stylesheet" href="<?php echo $this->url('assets/css/app.css'); ?>">
<script src="<?php echo $this->url('assets/js/theme.js'); ?>"></script>
<?php if ($this->setting['gtranslate']) { ?>
<script>window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"wrapper_selector":".gtranslate_wrapper","flag_size":24}</script>
<script src="<?php echo $this->url('assets/js/gtranslate.js'); ?>" defer></script>
<?php } ?>