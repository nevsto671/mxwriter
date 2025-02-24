
    <script src="<?php echo $this->url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo $this->url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo $this->url('assets/js/animated-headline.js'); ?>"></script>
    <script src="<?php echo $this->url('assets/js/script.js'); ?>"></script>
    <?php if ($this->setting['tracking_id']) { ?>
    <script src="https://www.googletagmanager.com/gtag/js?id=<?php echo $this->setting['tracking_id']; ?>" async></script>
    <script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '<?php echo $this->setting['tracking_id']; ?>');</script>
    <?php } ?>
