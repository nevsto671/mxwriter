<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
  <?php require_once __DIR__ . '/Head.php'; ?>
</head>

<body class="home-page">
  <?php require_once __DIR__ . '/Header.php'; ?>
  <div data-bs-spy="scroll" data-bs-target="#navbar">
    <div class="masthead">
      <div class="container">
        <div class="text-center">
          <div class="tagline">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stars" viewBox="0 0 16 16">
              <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z" />
            </svg><span class="ms-2">Create quality content in under a minute</span>
          </div><br><br>
          <h1 class="display-3 fw-bold">Platform For Creating Content</h1>
          <div class="cd-intro my-3">
            <h2 class="cd-headline clip">
              <span class="cd-words-wrapper">
                <b class="gradient-text is-visible">Chat Assistant</b>
                <b class="gradient-text">Data Analyst</b>
                <b class="gradient-text">Image Generator</b>
                <b class="gradient-text">Article Generator</b>
                <b class="gradient-text">Content Rewrite</b>
                <b class="gradient-text">Taglines & Headlines</b>
                <b class="gradient-text">Product Description</b>
                <b class="gradient-text">Facebook Ad</b>
                <b class="gradient-text">Instagram Posts</b>
                <b class="gradient-text">YouTube Description</b>
                <b class="gradient-text">Email & Message</b>
                <b class="gradient-text">Testimonial & Review</b>
                <b class="gradient-text">Profile Bio</b>
              </span>
            </h2>
          </div>
          <div class="mb-5 fw-normal fs-4">AI writing is here to help you create high-quality content in just a few seconds.</div>
          <a class="btn btn-lg btn-primary px-5 py-3 fs-6 fw-semibold mb-3 mx-2" href="<?php echo $this->uid ? $this->url('my') : $this->url('signup'); ?>">Get Started</a>
          <?php if (!empty($this->setting['demo_link'])) { ?>
            <a class="btn btn-lg btn-light px-3 py-2 fs-6 fw-semibold mb-3 mx-2" href="<?php echo $this->setting['demo_link']; ?>" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-youtube-filled" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18 3a5 5 0 0 1 5 5v8a5 5 0 0 1 -5 5h-12a5 5 0 0 1 -5 -5v-8a5 5 0 0 1 5 -5zm-9 6v6a1 1 0 0 0 1.514 .857l5 -3a1 1 0 0 0 0 -1.714l-5 -3a1 1 0 0 0 -1.514 .857z" stroke-width="0" fill="#e31f1e" />
              </svg><span class="ms-2">Watch Demo</span>
            </a>
          <?php } ?>
          <div class="small">No credit card required</div>
        </div>
      </div>
    </div>
    <div class="section pt-0">
      <div class="container">
        <div class="col-xl-10 mx-auto">
          <div class="text-center mb-5">
            <div class="display-6 fw-bold mb-3">How it works?</div>
            <p class="fs-5">Use these step to generate high-quality content.</p>
          </div>
          <div class="row gy-4 g-sm-5">
            <div class="col-sm-6 col-lg-4">
              <div class="text-center">
                <div class="display-4">1</div>
                <div class="my-1 fw-bold fs-5">Select use-case</div>
                <div>Our content creation template library offers a variety of use case for all your needs.</div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4">
              <div class="text-center">
                <div class="display-4">2</div>
                <div class="my-1 fw-bold fs-5">Input some context</div>
                <div>Guidance to the AI by inputting relevant information to generate text based on the given context.</div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4">
              <div class="text-center">
                <div class="display-4">3</div>
                <div class="my-1 fw-bold fs-5">Generate results</div>
                <div>Get plagiarism-free high-quality content that tailored to your needs and can be used on any platform.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="use-cases"></div>
    </div>
    <?php if (!empty($templates)) { ?>
      <div class="section">
        <div class="container">
          <div class="col-xl-10 mx-auto">
            <div class="text-center mb-5">
              <div class="display-6 fw-bold mb-3">Use cases</div>
              <p class="fs-5">Our templates are designed to provide you quickly and easily create high-quality content.</p>
            </div>
            <div class="row g-3" id="tab-content">
              <?php foreach ($templates as $template) { ?>
                <div class="col-12 col-sm-6 col-md-4">
                  <a class="card p-3 text-decoration-none h-100 zoom" href="<?php echo $this->uid ? $this->url("my/templates/$template[slug]") : $this->url("login"); ?>">
                    <div class="d-flex justify-content-between mb-3">
                      <div>
                        <span class="rounded text-white mt-1 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px; background-color: <?php echo !empty($template['color']) ? $template['color'] : '#f4ac36'; ?>;">
                          <?php if (!empty($template['icon'])) {
                            echo $template['icon'];
                          } else { ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                              <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                              <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                            </svg>
                          <?php } ?>
                        </span>
                      </div>
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#bbb" class="bi bi-arrow-up-right" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0v-6z" />
                        </svg>
                      </div>
                    </div>
                    <div class="h6 fw-bold text-truncate"><?php echo $template['title']; ?></div>
                    <p class="text-muted mb-0"><?php echo $template['description']; ?></p>
                  </a>
                </div>
              <?php } ?>
            </div>
            <div class="text-center pt-5">
              <a class="btn btn-lg btn-outline-secondary fw-bold px-4 fs-6" href="<?php echo $this->url("login"); ?>">View all tools</a>
            </div>
          </div>
        </div>
        <div id="pricing"></div>
      </div>
    <?php } ?>
    <?php if (!empty($plans)) { ?>
      <div class="section">
        <div class="container">
          <div class="col-xl-10 mx-auto">
            <div class="text-center mb-5">
              <div class="display-6 fw-bold mb-3">Pricing</div>
              <p class="fs-5">Our plans are simple and clear, they are based on the total credits used in each month.</p>
            </div>
            <?php if (!empty($plans) && count($plans) > 1) { ?>
              <ul class="nav nav-pills justify-content-center mb-5" id="pricing-tab" role="tablist">
                <li class="nav-item border bg-transparent border-0" role="presentation">
                  <button class="nav-link rounded active" data-bs-toggle="pill" data-bs-target="#tab-month" type="button" role="tab" aria-controls="tab-month" aria-selected="true">Monthly</button>
                </li>
                <?php if (!empty($plans['year'])) { ?>
                  <li class="nav-item border bg-transparent border-0" role="presentation">
                    <button class="nav-link rounded" data-bs-toggle="pill" data-bs-target="#tab-year" type="button" role="tab" aria-controls="tab-year" aria-selected="false">Yearly</button>
                  </li>
                <?php } ?>
                <?php if (!empty($plans['prepaid'])) { ?>
                  <li class="nav-item border bg-transparent border-0" role="presentation">
                    <button class="nav-link rounded" data-bs-toggle="pill" data-bs-target="#tab-prepaid" type="button" role="tab" aria-controls="tab-prepaid" aria-selected="false">Prepaid</button>
                  </li>
                <?php } ?>
              </ul>
            <?php } ?>
            <div class="tab-content mb-5" id="pills-tabContent">
              <?php foreach ($plans as $key => $results) { ?>
                <div class="tab-pane <?php echo $key == 'month' ? 'show active' : null; ?>" id="tab-<?php echo $key; ?>" role="tabpanel" tabindex="0">
                  <div class="row g-3 justify-content-center">
                    <?php foreach ($results as $plan) {
                      $description = !empty($plan['description']) ? explode(PHP_EOL, $plan['description']) : []; ?>
                      <div class="col-12 col-md-6 col-xl-3">
                        <div class="card h-100 shadow-sm border <?php echo !empty($plan['highlight']) ? 'border-warning' : null; ?>" <?php echo !empty($plan['highlight']) ? 'style="border-color: #f7d700;"' : null; ?>>
                          <?php if (!empty($plan['highlight'])) { ?>
                            <div class="position-absolute w-100 text-center p-2 fw-bold" style="color: #000000; background-color: #f7d700;">
                              Most Popular
                            </div>
                          <?php } ?>
                          <div class="card-body text-center">
                            <div class="my-5">
                              <div class="h5 fw-bold mb-2"><?php echo $plan['name']; ?></div>
                              <div class="mb-4"><?php echo isset($plan['title_' . $this->setting['language']]) ? $plan['title_' . $this->setting['language']] : $plan['title']; ?></div>
                              <div class="mb-4">
                                <div class="fw-bold h2 mb-0"><?php echo $this->price($plan['price']); ?></div>
                                <div class="text-muted"><?php echo $plan['duration'] == 'month' ? "Per Month" : ($plan['duration'] == 'year' ? "Per Year" : "One Time Payment"); ?></div>
                              </div>
                              <div class="px-3">
                                <?php if (isset($this->user['plan_id']) && $this->user['plan_id'] == $plan['id']) { ?>
                                  <a class="btn shadow-none w-100 mb-1 disabled" href="<?php echo $this->url("my/plans"); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                    </svg><span class="mx-2">Subscribed</span>
                                  </a>
                                <?php } else { ?>
                                  <a class="btn btn-primary btn-spinner shadow-none w-100 mb-1" href="<?php echo $this->uid ? $this->url("my/plans?id=$plan[id]") : $this->url("login"); ?>">
                                    <?php echo $plan['duration'] == 'prepaid' ? 'Buy now' : 'Subscribe'; ?>
                                  </a>
                                <?php } ?>
                              </div>
                              <?php if (!empty($description)) { ?>
                                <div class="text-start px-3 my-4">
                                  <?php foreach ($description as $val) { ?>
                                    <div class="mb-3">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#00b806" class="bi bi-check2" viewBox="0 0 16 16">
                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                      </svg><span class="ms-2"><?php echo $val; ?></span>
                                    </div>
                                  <?php } ?>
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php if (!empty($testimonials)) { ?>
      <div class="section">
        <div class="container">
          <div class="text-center mb-5">
            <div class="display-5 mb-4 fw-semibold">What Client's Say</div>
            <p>A customer who is extremely pleased with their experience happily shares their positive feedback.</p>
          </div>
          <div class="row g-3 g-xl-4">
            <?php foreach ($testimonials as $testimonial) { ?>
              <div class="col-12 col-sm-6 col-md-4">
                <div class="card p-4 text-decoration-none h-100 gradient-background">
                  <div class="d-flex justify-content-between mb-2">
                    <div>
                      <div class="h6 fw-semibold mb-1"><?php echo $testimonial['name']; ?></div>
                      <small><?php echo $testimonial['role']; ?></small>
                    </div>
                    <div style="color: gold">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor" />
                      </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor" />
                      </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor" />
                      </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor" />
                      </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor" />
                      </svg>
                    </div>
                  </div>
                  <p class="mb-0"><?php echo $testimonial['description']; ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div id="faq"></div>
      </div>
    <?php } ?>
    <div class="section">
      <div class="container">
        <div class="col-xl-10 mx-auto">
          <div class="mb-5">
            <div class="col-lg-9 mx-auto pb-5">
              <h2 class="fw-bold mb-4 text-center">Frequently Asked Questions</h2>
              <hr>
              <div class="accordion accordion-flush" id="faqs">
                <div class="accordion-item bg-transparent py-3">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed shadow-none bg-transparent fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false">
                      Can I change my subscription plan later?
                    </button>
                  </h2>
                  <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqs">
                    <div class="accordion-body pt-0">
                      Yes, our subscription pricing plans allow you to change your plan at any time.
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-transparent py-3">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed shadow-none bg-transparent fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false">
                      Can I cancel my subscription anytime?
                    </button>
                  </h2>
                  <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqs">
                    <div class="accordion-body pt-0">
                      Yes, our subscription pricing plans allow you to cancel your subscription at any time without any penalty.
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-transparent py-3">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed shadow-none bg-transparent fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false">
                      What happens if I miss a payment?
                    </button>
                  </h2>
                  <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqs">
                    <div class="accordion-body pt-0">
                      If you miss a payment, your subscription may be suspended or canceled, then you can subscribe again.
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-transparent py-3">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed shadow-none bg-transparent fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false">
                      Is there any hidden fees with subscription plans?
                    </button>
                  </h2>
                  <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqs">
                    <div class="accordion-body pt-0">
                      No, our subscription pricing plans are transparent and do not have any hidden fees. The cost you pay is what you see on the pricing plan.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once __DIR__ . '/Footer.php'; ?>
  <?php require_once __DIR__ . '/Tail.php'; ?>
</body>

</html>