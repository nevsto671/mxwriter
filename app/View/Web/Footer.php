<footer>
	<div class="container">
		<div class="col-xl-9 mx-auto">
			<div class="row g-3">
				<div class="col-12 col-lg-6 mb-3">
					<div class="h6 fw-semibold mb-3">
						<?php if ($this->setting['site_logo_light']) { ?>
							<a href="<?php echo $this->url(null); ?>">
								<img class="site-logo logo-light" src="<?php echo $this->url($this->setting['site_logo_light']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
								<img class="site-logo logo-dark" src="<?php echo $this->url($this->setting['site_logo_dark']); ?>" alt="<?php echo $this->setting['site_name']; ?>">
							</a>
						<?php } else { ?>
							<a class="navbar-brand" href="<?php echo $this->url(null); ?>"><?php echo $this->setting['site_name']; ?></a>
						<?php } ?>
					</div>
					<p class="me-xl-4"><?php echo $this->setting['footer_text']; ?></p>
					<p><?php echo $this->setting['copyright']; ?></p>
				</div>
				<div class="col-6 col-lg-2">
					<div class="h6 fw-semibold mb-3">Follow Us</div>
					<ul class="list-unstyled">
						<li class="mb-2"><a href="<?php echo $this->setting['facebook_link'] ?: '#'; ?>">Facebook</a></li>
						<li class="mb-2"><a href="<?php echo $this->setting['twitter_link'] ?: '#'; ?>">Twitter</a></li>
						<li class="mb-2"><a href="<?php echo $this->setting['instagram_link'] ?: '#'; ?>">Instagram</a></li>
					</ul>
				</div>
				<div class="col-6 col-lg-2">
					<div class="h6 fw-semibold mb-3">Support</div>
					<ul class="list-unstyled">
						<li class="mb-2"><a href="<?php echo $this->url('faq'); ?>">FAQ</a></li>
						<li class="mb-2"><a href="<?php echo $this->url('about'); ?>">About Us</a></li>
						<li class="mb-2"><a href="<?php echo $this->url('contact'); ?>">Contact Us</a></li>
					</ul>
				</div>
				<div class="col-6 col-lg-2">
					<div class="h6 fw-semibold mb-3">Policy</div>
					<ul class="list-unstyled">
						<li class="mb-2"><a href="<?php echo $this->url('terms'); ?>">Terms of Use</a></li>
						<li class="mb-2"><a href="<?php echo $this->url('privacy-policy'); ?>">Privacy Policy</a></li>
						<li class="mb-2"><a href="<?php echo $this->url('refund-policy'); ?>">Refund Policy</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php if ($this->setting['gdpr_status'] && !isset($_COOKIE['_gdpr'])) { ?>
	<div id="gdpr-cookie-policy" class="toast show position-fixed bg-dark w-100 bottom-0 end-0 rounded-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
		<div class="toast-body text-center text-white p-2">
			This site uses cookies, by using this website you agree to our <a class="text-white" href="cookie-policy">cookie policy</a>. <button type="button" class="btn btn-sm bg-secondary text-white border-0 rounded-0 py-0 px-2 ms-2" data-bs-dismiss="toast">OK, got it</button>
		</div>
	</div>
<?php } ?>