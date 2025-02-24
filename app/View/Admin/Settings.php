<!doctype html>
<html lang="<?php echo $this->setting['direction'] == 'rtl' ? 'ar' : 'en'; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
    <?php require_once APP . '/View/User/Head.php'; ?>
</head>

<body>
    <?php require_once APP . '/View/Admin/Header.php'; ?>
    <main>
        <div class="container-fluid">
            <?php require_once APP . '/View/Admin/Sidebar.php'; ?>
            <div class="main">
                <div class="row justify-content-center justify-content-lg-start mb-4">
                    <div class="col-lg-3 col-xl-2">
                        <ul class="nav flex-lg-column mt-lg-2">
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'general' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=general"); ?>">General</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'finance' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=finance"); ?>">Finance</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'security' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=security"); ?>">Security</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'media' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=media"); ?>">Media</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'mail' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=mail"); ?>">Mail</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'marketing' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=marketing"); ?>">Marketing</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'social' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=social"); ?>">Social</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'testimonials' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=testimonials"); ?>">Testimonials</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'payment' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=payment"); ?>">Payment</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'schedule' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=schedule"); ?>">Schedule</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'openai' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=openai"); ?>">OpenAI</a></li>
                            <li class="nav-item"><a class="nav-link text-dark fw-semibold hover-blue <?php echo $tab == 'about' ? 'fw-bold' : null; ?>" href="<?php echo $this->url("admin/settings?tab=about"); ?>">About</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-9 col-xl-8" style="max-width: 800px;">
                        <?php if ($flash = $this->flash()) { ?>
                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                        <?php } ?>
                        <?php if ($tab == "general") { ?>
                            <div class="card p-3">
                                <h5 class="mb-3 fw-semibold">Site settings</h5>
                                <?php if (empty($image_writeable)) { ?>
                                    <div class="p-2 alert alert-danger">Write permission required, images directory not writable.</div>
                                <?php } ?>
                                <form method="post" class="form form-group">
                                    <div class="mb-4">
                                        <label for="site_name_text" class="form-label fw-semibold">Website name</label>
                                        <input id="site_name_text" type="text" name="site_name" class="form-control" placeholder="Example: Google" minlength="2" maxlength="40" value="<?php echo $setting['site_name']; ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="site_title_text" class="form-label fw-semibold">Website meta title</label>
                                        <input id="site_title_text" type="text" name="site_title" class="form-control" placeholder="Your website title" minlength="10" maxlength="70" value="<?php echo $setting['site_title']; ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="site_description_text" class="form-label fw-semibold">Website meta description</label>
                                        <input id="site_description_text" type="text" name="site_description" class="form-control" placeholder="Describe the contents of your website" minlength="20" maxlength="155" value="<?php echo $setting['site_description']; ?>" required>
                                    </div>
                                    <div class="row g-3 mb-4">
                                        <div class="col">
                                            <label for="language_select" class="form-label fw-semibold">Default language</label>
                                            <select id="language_select" name="language" class="form-select">
                                                <option value="en" <?php echo $setting['language'] == 'en' ? 'selected' : null; ?>>English</option>
                                            </select>
                                        </div>
                                        <div class="col d-none">
                                            <label for="direction_select" class="form-label fw-semibold">Language direction</label>
                                            <select id="direction_select" name="direction" class="form-select">
                                                <option value="ltr" <?php echo $setting['direction'] == 'ltr' ? 'selected' : null; ?>>Left to right (LTR)</option>
                                                <option value="rtl" <?php echo $setting['direction'] == 'rtl' ? 'selected' : null; ?>>Right to left (RTL)</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="theme_style" class="form-label fw-semibold">Default theme</label>
                                            <select id="theme_style" name="theme_style" class="form-select">
                                                <option value="auto" <?php echo $setting['theme_style'] == 'auto' ? 'selected' : null; ?>>Auto</option>
                                                <option value="light" <?php echo $setting['theme_style'] == 'light' ? 'selected' : null; ?>>Light</option>
                                                <option value="dark" <?php echo $setting['theme_style'] == 'dark' ? 'selected' : null; ?>>Dark</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row row-cols-2 g-3 mb-4">
                                        <div>
                                            <label for="date_format_select" class="form-label fw-semibold">Date format</label>
                                            <select id="date_format_select" name="date_format" class="form-select">
                                                <?php foreach ($date_format as $val) { ?>
                                                    <option value="<?php echo $val; ?>" <?php echo $val == $setting['date_format'] ? 'selected' : null; ?>><?php echo date($val, time()); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="time_format_select" class="form-label fw-semibold">Time format</label>
                                            <select id="time_format_select" name="time_format" class="form-select">
                                                <?php foreach ($time_format as $val) { ?>
                                                    <option value="<?php echo $val; ?>" <?php echo $val == $setting['time_format'] ? 'selected' : null; ?>><?php echo date($val, time()); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="time_zone_select" class="form-label fw-semibold">Time zone</label>
                                        <select id="time_zone_select" name="time_zone" class="form-select">
                                            <option value="UTC">(UTC) Default time zone</option>
                                            <?php foreach ($time_zone as $key => $val) { ?>
                                                <option value="<?php echo $key; ?>" <?php echo $key == $setting['time_zone'] ? 'selected' : null; ?>><?php echo $val; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="copyright_text" class="form-label fw-semibold">Copyright information</label>
                                        <input id="copyright_text" type="text" name="copyright" class="form-control" placeholder="Copyright information" minlength="3" maxlength="250" value="<?php echo !empty($setting['copyright']) ? htmlspecialchars($setting['copyright'], ENT_QUOTES, 'UTF-8') : null; ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="site_address" class="form-label fw-semibold">Organization address</label>
                                        <textarea id="site_address" name="site_address" class="form-control" rows="4" required><?php echo $setting['site_address']; ?></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="footer_text" class="form-label fw-semibold">Footer text</label>
                                        <textarea id="footer_text" name="footer_text" class="form-control" rows="4" required><?php echo $setting['footer_text']; ?></textarea>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-loader="Updating...">Update details</button>
                                    </div>
                                </form>
                            </div>
                        <?php } else if ($tab == "finance") { ?>
                            <div class="card p-3">
                                <h5 class="mb-3 fw-semibold">Finance settings</h5>
                                <form method="post" class="form form-group">
                                    <div class="mb-4">
                                        <label for="currency_select" class="form-label fw-semibold">Currency</label>
                                        <select id="currency_select" name="currency" class="form-select" data-selected="<?php echo $setting['currency']; ?>">
                                            <?php foreach ($currency as $val) { ?>
                                                <option value="<?php echo $val['code']; ?>"><?php echo $val['code']; ?> (<?php echo $val['title']; ?>)</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <div class="row row-cols-2 g-3">
                                            <div>
                                                <div class="row row-cols-2 g-3">
                                                    <div>
                                                        <label for="currency_symbol_text" class="form-label fw-semibold">Symbol</label>
                                                        <input id="currency_symbol_text" type="text" name="currency_symbol" class="form-control" maxlength="10" value="<?php echo $setting['currency_symbol']; ?>">
                                                    </div>
                                                    <div>
                                                        <label for="decimal_places_select" class="form-label fw-semibold">Decimal</label>
                                                        <select id="decimal_places_select" name="decimal_places" class="form-select" require>
                                                            <option value="0" <?php echo $setting['decimal_places'] == 0 ? 'selected' : null; ?>>0</option>
                                                            <option value="1" <?php echo $setting['decimal_places'] == 1 ? 'selected' : null; ?>>1</option>
                                                            <option value="2" <?php echo $setting['decimal_places'] == 2 ? 'selected' : null; ?>>2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="currency_position_select" class="form-label fw-semibold">Symbol position</label>
                                                <select id="currency_position_select" name="currency_position" class="form-select" require>
                                                    <option value="left" <?php echo $setting['currency_position'] == 'left' ? 'selected' : null; ?>>Left side of price</option>
                                                    <option value="right" <?php echo $setting['currency_position'] == 'right' ? 'selected' : null; ?>>Right side of price</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-cols-2 g-3 mb-4">
                                        <div>
                                            <label for="tax_number" class="form-label fw-semibold">Tax rate (%)</label>
                                            <input id="tax_number" name="tax" class="form-control" maxlength="12" value="<?php echo $setting['tax']; ?>" onkeypress="return /[0-9.]/i.test(event.key)">
                                        </div>
                                        <div>
                                            <label for="free_plan" class="form-label fw-semibold">Free plan</label>
                                            <select id="free_plan" name="free_plan" class="form-select notranslate">
                                                <option value="0">No plan</option>
                                                <?php foreach ($plans as $plan) { ?>
                                                    <option value="<?php echo $plan['id']; ?>" <?php echo $setting['free_plan'] == $plan['id'] ? 'selected' : null; ?>><?php echo $plan['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row row-cols-2 g-3 mb-4">
                                        <div>
                                            <label for="credits_words" class="form-label fw-semibold">Welcome credits - words</label>
                                            <input id="credits_words" name="credits_words" class="form-control" maxlength="12" value="<?php echo $setting['credits_words']; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                        </div>
                                        <div>
                                            <label for="credits_images" class="form-label fw-semibold">Welcome credits - images</label>
                                            <input id="credits_images" name="credits_images" class="form-control" maxlength="12" value="<?php echo $setting['credits_images']; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                        </div>
                                    </div>
                                    <div class="mb-4 form-check">
                                        <input type="checkbox" name="credits_extended" class="form-check-input" id="checkbox-credits-extended" <?php echo $setting['credits_extended'] ? 'checked' : null; ?>>
                                        <label class="form-check-label" for="checkbox-credits-extended">Carry forward unused credits on plan renewal (excludes free plans).</label>
                                    </div>
                                    <div class="mb-4 form-check">
                                        <input type="checkbox" name="credits_reset" class="form-check-input" id="checkbox-credits-reset" <?php echo $setting['credits_reset'] ? 'checked' : null; ?>>
                                        <label class="form-check-label" for="checkbox-credits-reset">Unused credits reset when the subscription expires.</label>
                                    </div>
                                    <div class="mb-4 form-check">
                                        <input type="checkbox" name="extended_status" class="form-check-input" id="checkbox-extended-status" <?php echo $setting['extended_status'] ? 'checked' : null; ?>>
                                        <label class="form-check-label" for="checkbox-extended-status">Prepaid plans are available for paid subscribers only.</label>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-loader="Updating...">Update details</button>
                                    </div>
                                </form>
                            </div>
                        <?php } else if ($tab == "security") { ?>
                            <div class="card p-3">
                                <h5 class="mb-3 fw-semibold">Security settings</h5>
                                <form method="post" class="form form-group">
                                    <div class="row g-3 g-lg-5">
                                        <div class="col-12 col-xl-6">
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="registration_status" class="form-check-input" id="checkbox-registration-status" <?php echo $setting['registration_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-registration-status">User registration enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="email_verification" class="form-check-input" id="checkbox-email-verification" <?php echo $setting['email_verification'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-email-verification">Email verification enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="device_verification" class="form-check-input" id="checkbox-device-verification" <?php echo $setting['device_verification'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-device-verification">Device verification enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="gdpr_status" class="form-check-input" id="checkbox-gdpr-status" <?php echo $setting['gdpr_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-gdpr-status">GDPR Cookie Policy banner show</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="maintenance_status" class="form-check-input" id="checkbox-maintenance-status" <?php echo $setting['maintenance_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-maintenance-status">Website maintenance mode enable</label>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">Google analytics Tracking ID</label>
                                                <input type="text" name="tracking_id" class="form-control" placeholder="e.g. G-000000-2" maxlength="30" value="<?php echo $setting['tracking_id']; ?>" style="max-width: 350px;">
                                            </div>
                                            <div class="mb-4">
                                                <label for="black-list" class="form-label fw-semibold">Bad word blacklist (separate by comma)</label>
                                                <input type="text" id="black-list" name="black_list" class="form-control" placeholder="e.g. word1, word2, word3" maxlength="240" value="<?php echo $black_list; ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-xl-6">
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="frontend_status" class="form-check-input" id="checkbox-status-disable" <?php echo $setting['frontend_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-status-disable">Landing page enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="template_status" class="form-check-input" id="checkbox-template-status" <?php echo $setting['template_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-template-status">Template enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="document_status" class="form-check-input" id="checkbox-document-status" <?php echo $setting['document_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-document-status">Documents enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="chat_status" class="form-check-input" id="checkbox-chat-status" <?php echo $setting['chat_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-chat-status">AI assistant enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="article_status" class="form-check-input" id="checkbox-article-status" <?php echo $setting['article_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-article-status">Article generator enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="rewrite_status" class="form-check-input" id="checkbox-rewrite-status" <?php echo $setting['rewrite_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-rewrite-status">Content rewriter enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="image_status" class="form-check-input" id="checkbox-image-status" <?php echo $setting['image_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-image-status">Image generator enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="editor_status" class="form-check-input" id="checkbox-editor-status" <?php echo $setting['editor_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-editor-status">Smart editor enable</label>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" name="blog_status" class="form-check-input" id="checkbox-blog-status" <?php echo $setting['blog_status'] ? 'checked' : null; ?>>
                                                <label class="form-check-label" for="checkbox-blog-status">Blog post enable</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($setting['maintenance_status']) { ?>
                                        <div class="mb-4">
                                            <label for="maintenance_message_text" class="form-label fw-semibold">Maintenance message</label>
                                            <textarea id="maintenance_message_text" name="maintenance_message" class="form-control" placeholder="Describes the maintenance reason and schedule" minlength="10" maxlength="250"><?php echo $setting['maintenance_message']; ?></textarea>
                                        </div>
                                    <?php } ?>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-loader="Updating...">Update details</button>
                                    </div>
                                </form>
                            </div>
                        <?php } else if ($tab == "media") { ?>
                            <?php if (empty($assets_writeable)) { ?>
                                <div class="p-2 alert alert-danger">Write permission required, assets/img directory not writable.</div>
                            <?php } ?>
                            <form method="post" class="form form-group">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="card p-3" id="favicon">
                                            <div class="upload_error p-2 alert alert-danger" style="display: none;"></div>
                                            <h5 class="fw-semibold">Favicon</h5>
                                            <p class="text-muted">Image at least 32 x 32 px square and .png file format only.</p>
                                            <div class="input-file-thumbnail mb-3 p-3">
                                                <img height="32" style="background-color: #f7f7f7;" src="<?php echo $this->url('assets/img/favicon.png'); ?>?v=<?php echo time(); ?>">
                                            </div>
                                            <input type="file" name="favicon" class="input-file" style="display: none" accept=".png" data-preload="true">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary input-file-button" data-upload="image" data-target="#favicon">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card p-3" id="site_logo">
                                            <div class="upload_error p-2 alert alert-danger" style="display: none;"></div>
                                            <h5 class="fw-semibold">Logo</h5>
                                            <p class="text-muted">At least 50 px height and .svg/.png/.jpg file format.</p>
                                            <div class="input-file-thumbnail mb-3 p-3" style="<?php echo empty($setting['site_logo']) ? "display: none" : null; ?>">
                                                <img height="32" style="background-color: #f7f7f7;" src="<?php echo !empty($setting['site_logo']) ? $setting['site_logo'] : 'data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA='; ?>?v=<?php echo time(); ?>">
                                            </div>
                                            <input type="file" name="site_logo" class="input-file" style="display: none" accept=".jpeg,.jpg,.png,.webp,.svg" data-preload="true">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary input-file-button" data-upload="image" data-target="#site_logo"><?php echo !empty($setting['site_logo']) ? 'Change' : 'Add'; ?></button>
                                                <?php if (!empty($setting['site_logo'])) { ?>
                                                    <button type="button" class="btn btn-danger ms-2" title="Click to delete" onclick="if (confirm('Are you sure you want to delete this logo?')) window.location.href='<?php echo $this->url('admin/settings?tab=media&delete=site_logo&sign=' . md5(date('d') . 'site_logo')); ?>';">Delete</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card p-3" id="site_logo_dark">
                                            <div class="upload_error p-2 alert alert-danger" style="display: none;"></div>
                                            <h5 class="fw-semibold">Dark logo - for light mode</h5>
                                            <p class="text-muted">At least 50 px height and .svg/.png/.jpg file format.</p>
                                            <div class="input-file-thumbnail mb-3 p-3" style="<?php echo empty($setting['site_logo_dark']) ? "display: none" : null; ?>">
                                                <img height="32" style="background-color: #f7f7f7;" src="<?php echo !empty($setting['site_logo_light']) ? $setting['site_logo_dark'] : 'data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA='; ?>?v=<?php echo time(); ?>">
                                            </div>
                                            <input type="file" name="site_logo_dark" class="input-file" style="display: none" accept=".jpeg,.jpg,.png,.webp,.svg" data-preload="true">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary input-file-button" data-upload="image" data-target="#site_logo_dark"><?php echo !empty($setting['site_logo_dark']) ? 'Change' : 'Add'; ?></button>
                                                <?php if (!empty($setting['site_logo_dark'])) { ?>
                                                    <button type="button" class="btn btn-danger ms-2" title="Click to delete" onclick="if (confirm('Are you sure you want to delete this logo?')) window.location.href='<?php echo $this->url('admin/settings?tab=media&delete=site_logo_dark&sign=' . md5(date('d') . 'site_logo_dark')); ?>';">Delete</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card p-3" id="site_logo_light">
                                            <div class="upload_error p-2 alert alert-danger" style="display: none;"></div>
                                            <h5 class="fw-semibold">Light logo - for dark mode</h5>
                                            <p class="text-muted">At least 50 px height and .svg/.png/.jpg file format.</p>
                                            <div class="input-file-thumbnail mb-3 p-3" style="<?php echo empty($setting['site_logo_light']) ? "display: none" : null; ?>">
                                                <img height="32" style="background-color: #21211f;" src="<?php echo !empty($setting['site_logo_light']) ? $setting['site_logo_light'] : 'data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA='; ?>?v=<?php echo time(); ?>">
                                            </div>
                                            <input type="file" name="site_logo_light" class="input-file" style="display: none" accept=".jpeg,.jpg,.png,.webp,.svg" data-preload="true">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary input-file-button" data-upload="image" data-target="#site_logo_light"><?php echo !empty($setting['site_logo_light']) ? 'Change' : 'Add'; ?></button>
                                                <?php if (!empty($setting['site_logo_light'])) { ?>
                                                    <button type="button" class="btn btn-danger ms-2" title="Click to delete" onclick="if (confirm('Are you sure you want to delete this logo?')) window.location.href='<?php echo $this->url('admin/settings?tab=media&delete=site_logo_light&sign=' . md5(date('d') . 'site_logo_light')); ?>';">Delete</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php } else if ($tab == "social") { ?>
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3 fw-semibold">Social follow link</h5>
                                <form method="post" class="form form-group">
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Facebook link</label>
                                        <input type="text" name="facebook_link" class="form-control" maxlength="250" value="<?php echo $setting['facebook_link']; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Twitter link</label>
                                        <input type="text" name="twitter_link" class="form-control" maxlength="250" value="<?php echo $setting['twitter_link']; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Instagram link</label>
                                        <input type="text" name="instagram_link" class="form-control" maxlength="250" value="<?php echo $setting['instagram_link']; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">LinkedIn link</label>
                                        <input type="text" name="linkedin_link" class="form-control" maxlength="250" value="<?php echo $setting['linkedin_link']; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Youtube demo video link</label>
                                        <input type="text" name="demo_link" class="form-control" maxlength="250" value="<?php echo $setting['demo_link']; ?>">
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-loader="Updating...">Update details</button>
                                    </div>
                                </form>
                            </div>
                            <?php if (isset($provider_google[0])) { ?>
                                <div class="card p-3 mb-3">
                                    <h5 class="mb-3 fw-semibold">Google sign in</h5>
                                    <form method="post" class="form form-group">
                                        <p class="small">Authorized redirect URI: <?php echo $this->url("login/" . strtolower($provider_google[0]['name'])); ?></p>
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold small">Client ID</label>
                                            <input type="text" name="google_client_id" class="form-control" minlength="3" value="<?php echo $provider_google[0]['key_id']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold small">Client secret</label>
                                            <input type="text" name="google_client_secret" class="form-control" minlength="3" value="<?php echo !empty($provider_google[0]['key_secret']) ? substr_replace($provider_google[0]['key_secret'], str_repeat('*', 15), 2, -1) : null; ?>">
                                        </div>
                                        <div class="mb-4 form-check">
                                            <input type="checkbox" name="google_status" class="form-check-input" id="checkbox-google-status" <?php echo $provider_google[0]['status'] ? 'checked' : null; ?>>
                                            <label class="form-check-label" for="checkbox-google-status">Google sign in enable</label>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary" data-loader="Updating...">Update details</button>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                            <?php if (isset($provider_facebook[0])) { ?>
                                <div class="card p-3 mb-3">
                                    <h5 class="mb-3 fw-semibold">Facebook sign in</h5>
                                    <form method="post" class="form form-group">
                                        <p class="small">OAuth Redirect URI: <?php echo $this->url("login/" . strtolower($provider_facebook[0]['name'])); ?></p>
                                        <div class="mb-4">
                                            <label for="key-id" class="form-label fw-semibold small">App ID</label>
                                            <input type="text" name="facebook_app_id" class="form-control" id="key-id" minlength="3" value="<?php echo $provider_facebook[0]['key_id']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label for="key-secret" class="form-label fw-semibold small">App secret</label>
                                            <input type="text" name="facebook_app_secret" class="form-control" id="key-secret" minlength="3" value="<?php echo !empty($provider_facebook[0]['key_secret']) ? substr_replace($provider_facebook[0]['key_secret'], str_repeat('*', 15), 2, -1) : null; ?>">
                                        </div>
                                        <div class="mb-4 form-check">
                                            <input type="checkbox" name="facebook_status" class="form-check-input" id="checkbox-facebook-status" <?php echo $provider_facebook[0]['status'] ? 'checked' : null; ?>>
                                            <label class="form-check-label" for="checkbox-facebook-status">Facebook sign in enable</label>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary" data-loader="Updating...">Update details</button>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                            <?php if (isset($provider_linkedin[0])) { ?>
                                <div class="card p-3 mb-3">
                                    <h5 class="mb-3 fw-semibold">Linkedin sign in</h5>
                                    <form method="post" class="form form-group">
                                        <p class="small">Redirect URI: <?php echo $this->url("login/" . strtolower($provider_linkedin[0]['name'])); ?></p>
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold small">Client ID</label>
                                            <input type="text" name="linkedin_client_id" class="form-control" minlength="3" value="<?php echo $provider_linkedin[0]['key_id']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold small">Client secret</label>
                                            <input type="text" name="linkedin_client_secret" class="form-control" minlength="3" value="<?php echo !empty($provider_linkedin[0]['key_secret']) ? substr_replace($provider_linkedin[0]['key_secret'], str_repeat('*', 15), 2, -1) : null; ?>">
                                        </div>
                                        <div class="mb-4 form-check">
                                            <input type="checkbox" name="linkedin_status" class="form-check-input" id="checkbox-linkedin-status" <?php echo $provider_linkedin[0]['status'] ? 'checked' : null; ?>>
                                            <label class="form-check-label" for="checkbox-linkedin-status">Linkedin sign in enable</label>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary" data-loader="Updating...">Update details</button>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        <?php } else if ($tab == "testimonials") { ?>
                            <?php if (!empty($testimonial)) { ?>
                                <div class="card p-3 mb-3">
                                    <h5 class="mb-4 fw-semibold">Update testimonial</h5>
                                    <form method="post" class="form form-group">
                                        <div class="mb-3">
                                            <label for="name-input" class="form-label fw-semibold">Name</label>
                                            <input type="text" name="name" class="form-control" id="name-input" value="<?php echo $testimonial['name']; ?>" placeholder="" minlength="2" maxlength="40" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name-role" class="form-label fw-semibold">Role</label>
                                            <input type="text" name="role" class="form-control" id="name-role" value="<?php echo $testimonial['role']; ?>" placeholder="" minlength="2" maxlength="40">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Description</label>
                                            <textarea name="description" class="form-control" rows="8" maxlength="2000" placeholder="" required><?php echo $testimonial['description']; ?></textarea>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-between">
                                            <div></div>
                                            <button type="button" class="btn p-0" title="Delete" onclick="if (confirm('Are you sure you want to delete this testimonial?')) window.location.href='<?php echo $this->url('admin/settings?tab=testimonials&id=' . base64_encode($testimonial['id']) . '&delete=' . md5($testimonial['id'])); ?>';">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div>
                                            <input type="hidden" name="updateTestimonial">
                                            <button type="submit" class="btn btn-primary" data-loader="Saving...">Update details</button>
                                        </div>
                                    </form>
                                </div>
                            <?php } else { ?>
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-3 fw-semibold">Testimonials</h5>
                                    <div>
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_testimonial">Add testimonial</button>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <?php foreach ($testimonials as $testimonial) { ?>
                                        <div class="col-12">
                                            <div class="card p-3 text-decoration-none h-100 gradient-background">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold notranslate"><?php echo $testimonial['name']; ?></h6>
                                                        <small class="text-secondary"><?php echo $testimonial['role']; ?></small>
                                                    </div>
                                                    <a class="text-decoration-none" title="Edit" href="<?php echo $this->url('admin/settings?tab=testimonials&id=' . base64_encode($testimonial['id'])); ?>">Edit</a>
                                                </div>
                                                <p class="mb-0"><?php echo $testimonial['description']; ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="modal fade" id="add_testimonial" tabindex="-1" aria-labelledby="add testimonial" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Add testimonial</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" class="form form-group">
                                                    <div class="mb-3">
                                                        <label for="name-input" class="form-label fw-semibold">Name</label>
                                                        <input type="text" name="name" class="form-control" id="name-input" placeholder="" minlength="2" maxlength="40" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name-role" class="form-label fw-semibold">Role</label>
                                                        <input type="text" name="role" class="form-control" id="name-role" placeholder="" minlength="2" maxlength="40">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Description</label>
                                                        <textarea name="description" class="form-control" rows="8" maxlength="2000" placeholder="" required></textarea>
                                                    </div>
                                                    <div>
                                                        <input type="hidden" name="addTestimonial">
                                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else if ($tab == "mail") { ?>
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3 fw-semibold">Mail settings</h5>
                                <form method="post" class="form form-group">
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Primary email address</label>
                                        <input type="email" name="site_email" class="form-control" value="<?php echo $setting['site_email']; ?>">
                                    </div>
                                    <div>
                                        <div class="mb-4">
                                            <label for="smtp_hostname" class="form-label fw-semibold notranslate">SMTP server</label>
                                            <input id="smtp_hostname" name="smtp_hostname" type="text" class="form-control" value="<?php echo $setting['smtp_hostname']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label for="smtp_port" class="form-label fw-semibold">SMTP port</label>
                                            <select id="smtp_port" name="smtp_port" class="form-select notranslate">
                                                <option value="587" <?php echo $setting['smtp_port'] == '587' ? 'selected' : null; ?>>587 (TLS)</option>
                                                <option value="465" <?php echo $setting['smtp_port'] == '465' ? 'selected' : null; ?>>465 (SSL)</option>
                                                <option value="25" <?php echo $setting['smtp_port'] == '25' ? 'selected' : null; ?>>25</option>
                                                <option value="26" <?php echo $setting['smtp_port'] == '26' ? 'selected' : null; ?>>26</option>
                                                <option value="2525" <?php echo $setting['smtp_port'] == '2525' ? 'selected' : null; ?>>2525</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="smtp_encryption" class="form-label fw-semibold">Security type</label>
                                            <select id="smtp_encryption" name="smtp_encryption" class="form-select notranslate">
                                                <option value="TLS" <?php echo $setting['smtp_encryption'] == 'TLS' ? 'selected' : null; ?>>TLS</option>
                                                <option value="SSL" <?php echo $setting['smtp_encryption'] == 'SSL' ? 'selected' : null; ?>>SSL</option>
                                                <option value="" <?php echo $setting['smtp_encryption'] == null ? 'selected' : null; ?>>None</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="smtp_username" class="form-label fw-semibold notranslate">SMTP username</label>
                                            <input id="smtp_username" name="smtp_username" type="text" class="form-control" value="<?php echo $setting['smtp_username']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label for="smtp_password" class="form-label fw-semibold notranslate">SMTP password</label>
                                            <input id="smtp_password" name="smtp_password" type="text" class="form-control" value="<?php echo !empty($setting['smtp_password']) ? substr_replace($setting['smtp_password'], str_repeat('*', 10), 2, -2) : null; ?>">
                                        </div>
                                        <div class="mb-4 form-check">
                                            <input type="checkbox" name="smtp_connection" class="form-check-input" id="checkbox-smtp-connection" value="" <?php echo $setting['smtp_connection'] ? 'checked' : null; ?>>
                                            <label class="form-check-label" for="checkbox-smtp-connection">Active SMPT mail server</label>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                        <button type="button" class="btn btn-light ms-2" data-bs-toggle="modal" data-bs-target="#testMailModal">Test mail</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal fade" id="testMailModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered modal-fullscreen-sm-down modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Send test mail</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post" class="form form-group">
                                            <div class="modal-body">
                                                <p class="mb-4">We will send an email to you, If mail arrived in your inbox or spam folder that means your mail server working successfully.</p>
                                                <div class="mb-2">
                                                    From: <?php echo $setting['site_email']; ?>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">To</span>
                                                    <input id="email" type="email" name="email" placeholder="Enter your email address" class="form-control" minlength="3" maxlength="100" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary w-100" data-loader="Sending...">Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($tab == "marketing") { ?>
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3 fw-semibold">Mailchimp</h5>
                                <form method="post" class="form form-group">
                                    <p class="small">Connect with Mailchimp marketing automation and email marketing platform. <a href="https://mailchimp.com" target="_blank">https://mailchimp.com</a>.</p>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold small">Api key</label>
                                        <input type="text" name="mailchimp_apikey" class="form-control" minlength="3" value="<?php echo !empty($setting['mailchimp_apikey']) ? substr_replace($setting['mailchimp_apikey'], str_repeat('*', 15), 2, -1) : null; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold small">Audience ID</label>
                                        <input type="text" name="mailchimp_audienceid" class="form-control" minlength="3" value="<?php echo $setting['mailchimp_audienceid']; ?>">
                                    </div>
                                    <div class="mb-4 form-check">
                                        <input type="checkbox" name="mailchimp_status" class="form-check-input" id="checkbox_mailchimp_status" <?php echo $setting['mailchimp_status'] ? 'checked' : null; ?>>
                                        <label class="form-check-label" for="checkbox_mailchimp_status">Active Mailchimp</label>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-loader="Updating...">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        <?php } else if ($tab == "payment") { ?>
                            <?php if (!empty($gateway)) { ?>
                                <div class="card p-3 mb-3">
                                    <h5 class="mb-3 fw-semibold notranslate"><?php echo $gateway['name']; ?> API Credential</h5>
                                    <?php if ($flash = $this->flash()) { ?>
                                        <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                                    <?php } ?>
                                    <?php if ($recurring) { ?>
                                        <div class="col-12 alert alert-warning py-2">
                                            <p>A webhook setup for automatic subscription renewal is required for recurring subscription payments at the end of the current subscription period.</p>
                                            Endpoint URL: <?php echo $this->url("payment/webhook/" . strtolower($gateway['provider'])); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($gateway['description'])) { ?>
                                        <div class="col-12 alert alert-light border py-2">
                                            <?php echo nl2br($gateway['description']); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($gateway['options'])) { ?>
                                        <div class="form-group">
                                            <form method="POST">
                                                <div class="mb-4">
                                                    <?php foreach ($options as $option) { ?>
                                                        <?php if ($option['key'] != 'live') { ?>
                                                            <div class="mb-4">
                                                                <label class="form-label fw-semibold small"><?php echo $option['label']; ?></label>
                                                                <input type="text" name="<?php echo $option['key']; ?>" class="form-control" placeholder="<?php echo isset($option['placeholder']) ? $option['placeholder'] : null; ?>" value="<?php echo !empty($option['value']) ? (in_array($option['key'], ['trialDays']) ? $option['value'] : substr_replace($option['value'], str_repeat('*', 15), 5, -2)) : null; ?>">
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="mb-2">
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="<?php echo $option['key']; ?>" class="form-check-input" id="checkbox-<?php echo $option['key']; ?>" <?php echo !empty($option['value']) ? 'checked' : null; ?>>
                                                                    <label class="form-check-label" for="checkbox-<?php echo $option['key']; ?>"><?php echo $option['label']; ?></label>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <?php if ($recurring) { ?>
                                                    <div class="mb-4">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="recurring" class="form-check-input" id="input-recurring" value="" <?php echo $gateway['recurring'] == 1 ? 'checked' : null; ?>>
                                                            <label class="form-check-label" for="input-recurring">Auto renewal at the end of the current subscription period. Note: webhook setup required.</label>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="mb-4">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="status" class="form-check-input" id="input-status" value="" <?php echo $gateway['status'] == 1 ? 'checked' : null; ?>>
                                                        <label class="form-check-label" for="input-status">Active payment gateway</label>
                                                    </div>
                                                </div>
                                                <div class="py-2 d-flex">
                                                    <button type="submit" class="btn btn-primary w-100" data-loader="Saving...">Save changes</button>
                                                    <a href="<?php echo $this->url("admin/settings?tab=payment"); ?>" class="btn btn-light ms-3 w-100">Cancel</a>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-muted">
                                            <p>This payment option not install yet.</p>
                                            <a href="<?php echo $this->url("admin/settings?tab=payment"); ?>" class="btn btn-light px-3">Back</a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <p>Make sure this payment gateway support <?php echo $this->setting['currency']; ?> currency and Api requests must be made over HTTPS, calls made over plain HTTP will fail.</p>
                            <?php } else { ?>
                                <?php if (!empty($payment_gateway)) { ?>
                                    <div class="card p-3 mb-3">
                                        <h5 class="mb-3 fw-semibold">Online payment gateway</h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 65px">Logo</th>
                                                        <th scope="col">Provider</th>
                                                        <th scope="col" class="text-end d-none">Recurring</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col" class="text-end" style="width: 50px">Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($payment_gateway as $gateway) { ?>
                                                        <tr>
                                                            <td><img src="<?php echo $this->url('assets/img/payment/' . strtolower($gateway['provider']) . '.png'); ?>" class="" alt="<?php echo $gateway['name']; ?>" width="42" height="42"></td>
                                                            <td>
                                                                <span class="fw-bold d-block mb-1 notranslate"><?php echo $gateway['name']; ?></span>
                                                                <small class="d-none d-md-table-cell text-muted"><?php echo $gateway['title'] ? $gateway['title'] : null; ?></small>
                                                            </td>
                                                            <td class="text-end d-none"><?php echo $gateway['recurring'] ? 'Enable' : 'Disable'; ?></td>
                                                            <td><?php echo $gateway['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                                            <td class="text-end"><a class="text-decoration-none" href="<?php echo $this->url("admin/settings?tab=payment&provider=$gateway[provider]"); ?>">Edit</a></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="card p-3">
                                    <h5 class="mb-3 fw-semibold">Offline payment</h5>
                                    <form method="post" class="form form-group">
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">Payment title</label>
                                            <input type="text" name="offline_payment_title" class="form-control" placeholder="e.g Bank Transfer" maxlength="60" value="<?php echo $setting['offline_payment_title']; ?>" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="offline_payment_guidelines" class="form-label fw-semibold">Payment guidelines</label>
                                            <textarea id="offline_payment_guidelines" name="offline_payment_guidelines" class="form-control" rows="3" maxlength="250" placeholder="Describe payment guidelines"><?php echo $setting['offline_payment_guidelines']; ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="offline_payment_recipient" class="form-label fw-semibold">Payment recipient accounts</label>
                                            <textarea id="offline_payment_recipient" name="offline_payment_recipient" class="form-control" rows="4" maxlength="250" placeholder="e.g. Bank name and Account number"><?php echo $setting['offline_payment_recipient']; ?></textarea>
                                        </div>
                                        <div class="mb-4 form-check">
                                            <input type="checkbox" name="offline_payment" class="form-check-input" id="checkbox-offline-payment" <?php echo $setting['offline_payment'] ? 'checked' : null; ?>>
                                            <label class="form-check-label" for="checkbox-offline-payment">Offline payment enable</label>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        <?php } else if ($tab == "schedule") { ?>
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3 fw-semibold">Cron job</h5>
                                <form method="post" class="form form-group">
                                    <h6 class="mb-3">Last updated: <?php echo !empty($setting['last_updated']) ? date($this->setting['time_format'], strtotime($setting['last_updated'])) : 'Unknown'; ?></h6>
                                    <p>Reload this page five minutes later. If last updated time changed, that's mean cron job schedule working. Otherwise manually set cron job schedule every 5 minutes by the following command. Cron job schedule will automatically update user subscription and other task.</p>
                                    <div>
                                        <label class="form-label">Command:</label>
                                        <div class="bg-light text-danger fst-italic small p-2 mb-2 notranslate">
                                            <?php echo $interval . ' ' . $command; ?>
                                        </div>
                                    </div>
                                    <a class="btn btn-primary text-decoration-none d-none" href="<?php echo $this->url("admin/settings?tab=schedule&setcronjob=" . md5(date('d'))); ?>" data-loader="Cron job Saving...">Add cron job schedule</a>
                                </form>
                            </div>
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3 fw-semibold">Schedule management</h5>
                                <form method="post" class="form form-group">
                                    <div class="mb-4 form-check">
                                        <input type="checkbox" name="remove_history" class="form-check-input" id="checkbox-remove-history" <?php echo $setting['remove_history'] ? 'checked' : null; ?>>
                                        <label class="form-check-label" for="checkbox-remove-history">Automatically remove 30 days old history</label>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        <?php } else if ($tab == "openai") { ?>
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3 fw-semibold">OpenAI API information</h5>
                                <p>Get your own api key from <a class="text-decoration-none" href="https://platform.openai.com">https://platform.openai.com</a></p>
                                <?php if (!empty($_GET['error']) && is_string($_GET['error'])) { ?>
                                    <div class="p-2 alert alert-danger"><?php echo $_GET['error']; ?></div>
                                <?php } ?>
                                <?php if (!empty($_GET['success']) && is_string($_GET['success'])) { ?>
                                    <div class="p-2 alert alert-success"><?php echo $_GET['success']; ?></div>
                                <?php } ?>
                                <form method="post" class="form form-group">
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">OpenAI ApiKey</label>
                                        <input type="text" name="openai_apikey" class="form-control" placeholder="OpenAI Apikey here" value="<?php echo !empty($setting['openai_apikey']) ? substr_replace($setting['openai_apikey'], str_repeat('*', 15), 8, -4) : null; ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">OpenAI Organization ID (optional)</label>
                                        <input type="text" name="openai_organization_id" class="form-control" placeholder="OpenAI organization ID here" value="<?php echo $setting['openai_organization_id']; ?>">
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button><button type="button" class="btn btn-light ms-3 btn-spinner" onclick="window.location.href='<?php echo $this->url('admin/settings?tab=openai&testApiKey=' . $this->token); ?>';">Test API</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3 fw-semibold">Default model</h5>
                                <form method="post" class="form form-group">
                                    <div class="row g-3 mb-4">
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Templates</label>
                                            <select name="default_template_model" class="form-select" onchange="if (!confirm('All the template models will be changed to this model.')) { this.selectedIndex = 0; }">
                                                <option value="" selected disabled>Select model</option>
                                                <?php foreach ($models as $model) {
                                                    if ($model['type'] == 'GPT') { ?>
                                                        <option translate="no" value="<?php echo $model['model']; ?>"><?php echo $model['name']; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Assistant</label>
                                            <select name="default_chat_model" class="form-select">
                                                <option value="" selected disabled>Select model</option>
                                                <?php foreach ($models as $model) {
                                                    if ($model['type'] == 'GPT') { ?>
                                                        <option translate="no" value="<?php echo $model['model']; ?>" <?php echo $model['model'] == $setting['default_chat_model']  ? 'selected' : null; ?>><?php echo $model['name']; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Data Analyst</label>
                                            <select name="default_analyst_model" class="form-select">
                                                <option value="" selected disabled>Select model</option>
                                                <?php foreach ($models as $model) {
                                                    if ($model['type'] == 'GPT') { ?>
                                                        <option translate="no" value="<?php echo $model['model']; ?>" <?php echo $model['model'] == $setting['default_analyst_model'] ? 'selected' : null; ?>><?php echo $model['name']; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Article Generator</label>
                                            <select name="default_article_model" class="form-select">
                                                <option value="" selected disabled>Select model</option>
                                                <?php foreach ($models as $model) {
                                                    if ($model['type'] == 'GPT') { ?>
                                                        <option translate="no" value="<?php echo $model['model']; ?>" <?php echo $model['model'] == $setting['default_article_model'] ? 'selected' : null; ?>><?php echo $model['name']; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Image Generator</label>
                                            <select name="default_image_model" class="form-select">
                                                <option value="" selected disabled>Select model</option>
                                                <?php foreach ($models as $model) {
                                                    if ($model['type'] == 'Image') { ?>
                                                        <option translate="no" value="<?php echo $model['model']; ?>" <?php echo $model['model'] == $setting['default_image_model'] ? 'selected' : null; ?>><?php echo $model['name']; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="hidden" name="submit_default_model" value="1">
                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Update details</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card p-3 mb-3">
                                <h5 class="mb-3 fw-semibold">Model</h5>
                                <?php if (!empty($models)) { ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Model</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col" class="text-end" style="width: 40px">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($models as $model) { ?>
                                                    <tr>
                                                        <td class="notranslate"><?php echo $model['name']; ?></td>
                                                        <td class="notranslate"><?php echo $model['model']; ?></td>
                                                        <td class="notranslate"><?php echo $model['type']; ?></td>
                                                        <td class="text-end">
                                                            <a href="<?php echo $this->url("admin/settings?tab=openai&deleteModel=$model[id]&sign=" . md5(date('H'))); ?>" class="btn p-0 border-0 shadow-none" title="Delete" onclick="return confirm('Are you sure you want to delete this model?');">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="mb-3">
                                        Not available
                                    </div>
                                <?php } ?>
                                <div>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_model">Add new model</button>
                                </div>
                                <div class="modal fade" id="add_model" tabindex="-1" aria-labelledby="add model" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Add new model</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" class="form form-group">
                                                    <div class="mb-4">
                                                        <label for="model_type" class="form-label fw-semibold">Model type</label>
                                                        <select id="model_type" name="modelType" class="form-select notranslate">
                                                            <option value="GPT" selected>GPT</option>
                                                            <option value="Image">Image</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="name-input" class="form-label fw-semibold">Name</label>
                                                        <input type="text" name="modelName" class="form-control" id="name-input" placeholder="e.g. GPT 4 Model" minlength="2" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="modelid-input" class="form-label fw-semibold">Model</label>
                                                        <input type="text" name="modelId" class="form-control" id="modelid-input" placeholder="e.g. gpt-4" minlength="2" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary w-100" data-loader="Saving...">Add</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion" id="openaiAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed shadow-none bg-transparent fs-6 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#openaiLanguageCollapse" aria-expanded="false">
                                            Language
                                        </button>
                                    </h2>
                                    <div id="openaiLanguageCollapse" class="accordion-collapse collapse" data-bs-parent="#openaiAccordion">
                                        <div class="accordion-body mb-3">
                                            <?php if (!empty($languages)) { ?>
                                                <form method="post" class="form form-group">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">Default</th>
                                                                    <th scope="col" class="text-end">Status</th>
                                                                    <th scope="col" class="text-end" style="width: 50px">Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($languages as $language) { ?>
                                                                    <tr>
                                                                        <td><?php echo $language['name']; ?></td>
                                                                        <td><input type="radio" name="default_language[]" value="<?php echo $language['name']; ?>" class="form-check-input" <?php echo $language['selected'] ? 'checked' : null; ?>></td>
                                                                        <td class="text-end"><input type="checkbox" value="1" name="languageStatus[<?php echo $language['name']; ?>]" class="form-check-input" <?php echo $language['status'] ? 'checked' : null; ?>></td>
                                                                        <td class="text-end">
                                                                            <a href="<?php echo $this->url("admin/settings?tab=openai&deleteLanguage=$language[name]&sign=" . md5(date('H'))); ?>" class="btn p-0 border-0 shadow-none" title="Delete" onclick="return confirm('Are you sure you want to delete this language?');">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                    <path d="M4 7l16 0" />
                                                                                    <path d="M10 11l0 6" />
                                                                                    <path d="M14 11l0 6" />
                                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                                </svg>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div>
                                                        <input type="hidden" name="updateLanguage">
                                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                                        <button class="btn btn-light ms-2" type="button" data-bs-toggle="modal" data-bs-target="#add_language">Add new language</button>
                                                    </div>
                                                </form>
                                                <div class="modal fade" id="add_language" tabindex="-1" aria-labelledby="add Language" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5">Add new language</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" class="form form-group">
                                                                    <div class="mb-5">
                                                                        <label for="name-input" class="form-label fw-semibold">Language name</label>
                                                                        <input type="text" name="languageName" class="form-control" id="name-input" placeholder="e.g. English" minlength="2" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary w-100" data-loader="Saving...">Save changes</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed shadow-none bg-transparent fs-6 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#openaiToneCollapse" aria-expanded="false">
                                            Tone
                                        </button>
                                    </h2>
                                    <div id="openaiToneCollapse" class="accordion-collapse collapse" data-bs-parent="#openaiAccordion">
                                        <div class="accordion-body mb-3">
                                            <?php if (!empty($tones)) { ?>
                                                <form method="post" class="form form-group">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col" class="text-end">Status</th>
                                                                    <th scope="col" class="text-end" style="width: 50px">Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($tones as $tone) { ?>
                                                                    <tr>
                                                                        <td><?php echo $tone['name']; ?></td>
                                                                        <td class="text-end"><input type="checkbox" value="1" name="toneStatus[<?php echo $tone['name']; ?>]" class="form-check-input" id="checkbox-status" <?php echo $tone['status'] ? 'checked' : null; ?>></td>
                                                                        <td class="text-end">
                                                                            <a href="<?php echo $this->url("admin/settings?tab=openai&deleteTone=$tone[name]&sign=" . md5(date('H'))); ?>" class="btn p-0 border-0 shadow-none" title="Delete" onclick="return confirm('Are you sure you want to delete this tone?');">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                    <path d="M4 7l16 0" />
                                                                                    <path d="M10 11l0 6" />
                                                                                    <path d="M14 11l0 6" />
                                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                                </svg>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div>
                                                        <input type="hidden" name="updateTone">
                                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                                        <button class="btn btn-light ms-2" type="button" data-bs-toggle="modal" data-bs-target="#add_tone">Add voice tone</button>
                                                    </div>
                                                </form>
                                                <div class="modal fade" id="add_tone" tabindex="-1" aria-labelledby="add tone" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5">Add voice tone</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" class="form form-group">
                                                                    <div class="mb-5">
                                                                        <label for="name-input" class="form-label fw-semibold">Voice tone name</label>
                                                                        <input type="text" name="toneName" class="form-control" id="name-input" placeholder="e.g. Formal" minlength="2" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary w-100" data-loader="Saving...">Save changes</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($tab == "about") { ?>
                            <div class="card p-3">
                                <h4 class="mb-3 fw-semibold notranslate">Raitor</h4>
                                <p>Version: <?php echo $setting['version']; ?></p>
                                <p>Automatic content and image generator SaaS AI platform.</p>
                                <p>If you need any assistance then contact our support.</p>
                                <p>Email: <a class="text-dark text-decoration-none" href="mailto:sohel6bd@gmail.com" target="_blank">sohel6bd@gmail.com</a></p>
                                <p>Github: <a class="text-dark text-decoration-none" href="https://github.com/sohelrn" target="_blank">https://github.com/sohelrn</a></p>
                                <?php if (isset($_GET['activation'])) { ?>
                                    <form method="post" class="form mt-4">
                                        <p>Site key: <?php echo $siteKey; ?></p>
                                        <div class="mb-3">
                                            <input type="text" name="activationKey" class="form-control" id="name-input" placeholder="Enter activation key" minlength="15" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                    </form>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>