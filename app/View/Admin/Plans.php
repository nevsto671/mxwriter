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
                <?php if (isset($_GET['add'])) { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-md-10 col-xxl-8 offset-lg-1">
                            <div class="card border-0 p-3">
                                <h5 class="fw-bold mb-4">Add new plan</h5>
                                <div>
                                    <form method="post" class="form" novalidate>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Plan name</label>
                                                <input type="text" name="name" class="form-control" minlength="2" placeholder="e.g. Standard" value="<?php echo isset($_POST['name']) ? $_POST['name'] : null; ?>" required>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Plan title</label>
                                                <input type="text" name="title" class="form-control" minlength="2" placeholder="e.g. 200k words generate" value="<?php echo isset($_POST['title']) ? $_POST['title'] : null; ?>" required>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="description" class="form-label text-muted">Description (optional)</label>
                                            <textarea id="description" name="description" class="form-control" rows="10" placeholder="features list"><?php echo isset($_POST['description']) ? $_POST['description'] : null; ?></textarea>
                                        </div>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-12 col-md-6">
                                                <label for="input-type" class="form-label text-muted small">Payment frequency</label>
                                                <select name="duration" class="form-select" required>
                                                    <option value="month">Monthly</option>
                                                    <option value="year">Yearly</option>
                                                    <option value="lifetime">Lifetime</option>
                                                    <option value="prepaid">Prepaid</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Subscription fee (<?php echo $this->setting['currency']; ?>)</label>
                                                <input type="text" name="price" class="form-control" minlength="1" placeholder="e.g. 15" value="<?php echo isset($_POST['price']) ? $_POST['price'] : null; ?>" onkeypress="return /[0-9.]/i.test(event.key)" required>
                                            </div>
                                        </div>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Maximum word generate</label>
                                                <input type="text" name="words" class="form-control" placeholder="200000" value="<?php echo isset($_POST['words']) ? $_POST['words'] : 0; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                                <div class="small text-muted">Make it blank for unlimited word generate</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Maximum image generate</label>
                                                <input type="text" name="images" class="form-control" placeholder="500" value="<?php echo isset($_POST['images']) ? $_POST['images'] : 0; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                                <div class="small text-muted">Make it blank for unlimited image generate</div>
                                            </div>
                                        </div>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Maximum documents create</label>
                                                <input type="text" name="documents" class="form-control" placeholder="100" value="<?php echo isset($_POST['documents']) ? $_POST['documents'] : 0; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                                <div class="small text-muted">Make it blank for unlimited document create</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-check">
                                                    <input type="checkbox" name="status" class="form-check-input" id="input-status" checked>
                                                    <label class="form-check-label" for="input-status">Visible to public</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="highlight" class="form-check-input" id="input-highlight">
                                                    <label class="form-check-label" for="input-highlight">Plan highlighting</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-check">
                                                    <input type="checkbox" name="premium" class="form-check-input" id="input-premium">
                                                    <label class="form-check-label" for="input-premium">Premium access</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="assistant" class="form-check-input" id="input-assistant">
                                                    <label class="form-check-label" for="input-assistant">Assistant access</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="analyst" class="form-check-input" id="input-analyst">
                                                    <label class="form-check-label" for="input-analyst">Data analyst access</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="py-2 d-flex">
                                            <button type="submit" class="btn btn-primary w-100" data-loader="Saving...">Save details</button>
                                            <a href="<?php echo $this->url("admin/plans"); ?>" class="btn btn-light ms-3 w-100">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else if (isset($_GET['edit']) && !empty($plan)) { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-md-10 col-xxl-8 offset-lg-1">
                            <div class="card border-0 p-3">
                                <?php if ($flash = $this->flash()) { ?>
                                    <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                                <?php } ?>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <h4 class="fw-bold mb-4"><?php echo $plan['name']; ?></h4>
                                        <?php if ($plan['id'] == $setting['free_plan']) { ?>
                                            <div class="mt-1"><span class="badge text-bg-warning ms-3">Free</span></div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <a class="btn btn-sm border-0" href="<?php echo $this->url('admin/plans?edit=' . $plan['id'] . '&duplicate=' . md5($plan['id'])) ?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create duplicate">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <form method="post" class="form" novalidate>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Plan name</label>
                                                <input type="text" name="name" class="form-control" minlength="2" placeholder="e.g. Standard" value="<?php echo isset($plan['name']) ? $plan['name'] : null; ?>" required>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Plan title</label>
                                                <input type="text" name="title" class="form-control" minlength="2" placeholder="e.g. 200k words generate" value="<?php echo isset($plan['title']) ? $plan['title'] : null; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="description" class="form-label text-muted">Description (optional)</label>
                                            <textarea id="description" name="description" class="form-control" rows="10" placeholder="features list"><?php echo isset($plan['description']) ? $plan['description'] : null; ?></textarea>
                                        </div>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-12 col-md-6">
                                                <label for="input-type" class="form-label text-muted small">Payment frequency</label>
                                                <select name="duration" class="form-select" required>
                                                    <option value="month" <?php echo $plan['duration'] == 'month' ? 'selected' : null; ?>>Monthly</option>
                                                    <option value="year" <?php echo $plan['duration'] == 'year' ? 'selected' : null; ?>>Yearly</option>
                                                    <option value="lifetime" <?php echo $plan['duration'] == 'lifetime' ? 'selected' : null; ?>>Lifetime</option>
                                                    <option value="prepaid" <?php echo $plan['duration'] == 'prepaid' ? 'selected' : null; ?>>Prepaid</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Subscription fee (<?php echo $this->setting['currency']; ?>)</label>
                                                <input type="text" name="price" class="form-control" minlength="1" placeholder="e.g. 15" value="<?php echo isset($plan['price']) ? floatval($plan['price']) : null; ?>" onkeypress="return /[0-9.]/i.test(event.key)" required>
                                            </div>
                                        </div>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Maximum word generate</label>
                                                <input type="text" name="words" class="form-control" placeholder="200000" value="<?php echo isset($plan['words']) ? $plan['words'] : null; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                                <div class="small text-muted">Make it blank for unlimited word generate</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Maximum image generate</label>
                                                <input type="text" name="images" class="form-control" placeholder="500" value="<?php echo isset($plan['images']) ? $plan['images'] : null; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                                <div class="small text-muted">Make it blank for unlimited image generate</div>
                                            </div>
                                        </div>
                                        <div class="row gy-4 mb-4">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label text-muted small">Maximum documents create</label>
                                                <input type="text" name="documents" class="form-control" placeholder="100" value="<?php echo isset($plan['documents']) ? $plan['documents'] : null; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                                <div class="small text-muted">Make it blank for unlimited document create</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-check">
                                                    <input type="checkbox" name="status" class="form-check-input" id="input-status" value="" <?php echo $plan['status'] == 1 ? 'checked' : null; ?>>
                                                    <label class="form-check-label" for="input-status">Visible to public</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="highlight" class="form-check-input" id="input-highlight" value="" <?php echo $plan['highlight'] == 1 ? 'checked' : null; ?>>
                                                    <label class="form-check-label" for="input-highlight">Plan highlighting</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-check">
                                                    <input type="checkbox" name="premium" class="form-check-input" id="input-premium" <?php echo $plan['premium'] == 1 ? 'checked' : null; ?>>
                                                    <label class="form-check-label" for="input-premium">Premium access</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="assistant" class="form-check-input" id="input-assistant" <?php echo $plan['assistant'] == 1 ? 'checked' : null; ?>>
                                                    <label class="form-check-label" for="input-assistant">Assistant access</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="analyst" class="form-check-input" id="input-analyst" <?php echo $plan['analyst'] == 1 ? 'checked' : null; ?>>
                                                    <label class="form-check-label" for="input-analyst">Data analyst access</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <button type="submit" class="btn btn-primary" data-loader="Updating...">Update details</button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-danger" title="Delete" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" onclick="if (confirm('Are you sure you want to delete this plan?')) window.location.href='<?php echo $this->url('admin/plans?delete=' . $plan['id'] . '&sign=' . md5($plan['id'])); ?>';">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold mb-4">Plans and Pricing</h2>
                            <div>
                                <a class="btn btn-primary" href="<?php echo $this->url("admin/plans?add"); ?>">Add new plan</a>
                            </div>
                        </div>
                        <?php if ($flash = $this->flash()) { ?>
                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                        <?php } ?>
                        <?php if ($monthly_plans) { ?>
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3">Monthly plan</h5>
                                <div class="card border-0 p-3">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Plan name</th>
                                                    <th scope="col">Pricing</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Words</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Images</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Premium</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Assistant</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Analyst</th>
                                                    <th scope="col" class="d-none d-sm-table-cell" style="width: 60px">Status</th>
                                                    <th scope="col" class="text-end" style="width: 50px">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($monthly_plans as $plan) { ?>
                                                    <tr>
                                                        <td>
                                                            <span class="fw-semibold notranslate"><?php echo $plan['name']; ?></span>
                                                            <?php if ($plan['id'] == $setting['free_plan']) { ?>
                                                                <span class="badge text-bg-warning ms-2">Free</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="notranslate"><?php echo $this->price($plan['price']) . '/m'; ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo (is_null($plan['words']) ? 'Unlimited' : $plan['words']); ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo (is_null($plan['images']) ? 'Unlimited' : $plan['images']); ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['premium'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['assistant'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['analyst'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                                        <td class="text-end"><a class="text-decoration-none" href="<?php echo $this->url("admin/plans?edit=$plan[id]"); ?>">Edit</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($yearly_plans) { ?>
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3">Yearly plan</h5>
                                <div class="card border-0 p-3">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Plan name</th>
                                                    <th scope="col">Pricing</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Words</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Images</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Premium</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Assistant</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Analyst</th>
                                                    <th scope="col" class="d-none d-sm-table-cell" style="width: 60px">Status</th>
                                                    <th scope="col" class="text-end" style="width: 50px">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($yearly_plans as $plan) { ?>
                                                    <tr>
                                                        <td>
                                                            <span class="fw-semibold notranslate"><?php echo $plan['name']; ?></span>
                                                            <?php if ($plan['id'] == $setting['free_plan']) { ?>
                                                                <span class="badge text-bg-warning ms-2">Free</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="notranslate"><?php echo $this->price($plan['price']) . '/y'; ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo (is_null($plan['words']) ? 'Unlimited' : $plan['words']); ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo (is_null($plan['images']) ? 'Unlimited' : $plan['images']); ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['premium'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['assistant'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['analyst'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                                        <td class="text-end"><a class="text-decoration-none" href="<?php echo $this->url("admin/plans?edit=$plan[id]"); ?>">Edit</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($lifetime_plans) { ?>
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3">Lifetime plan</h5>
                                <div class="card border-0 p-3">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Plan name</th>
                                                    <th scope="col">Pricing</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Words</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Images</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Premium</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Assistant</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Analyst</th>
                                                    <th scope="col" class="d-none d-sm-table-cell" style="width: 60px">Status</th>
                                                    <th scope="col" class="text-end" style="width: 50px">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($lifetime_plans as $plan) { ?>
                                                    <tr>
                                                        <td>
                                                            <span class="fw-semibold notranslate"><?php echo $plan['name']; ?></span>
                                                            <?php if ($plan['id'] == $setting['free_plan']) { ?>
                                                                <span class="badge text-bg-warning ms-2">Free</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="notranslate"><?php echo $this->price($plan['price']); ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo (is_null($plan['words']) ? 'Unlimited' : $plan['words']); ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo (is_null($plan['images']) ? 'Unlimited' : $plan['images']); ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['premium'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['assistant'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['analyst'] == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                                        <td class="text-end"><a class="text-decoration-none" href="<?php echo $this->url("admin/plans?edit=$plan[id]"); ?>">Edit</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($prepaid_plans) { ?>
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3">Prepaid plan</h5>
                                <div class="card border-0 p-3">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Plan name</th>
                                                    <th scope="col">Pricing</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Words</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Images</th>
                                                    <th scope="col" class="d-none d-sm-table-cell" style="width: 60px">Status</th>
                                                    <th scope="col" class="text-end" style="width: 50px">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($prepaid_plans as $plan) { ?>
                                                    <tr>
                                                        <td>
                                                            <span class="fw-semibold notranslate"><?php echo $plan['name']; ?></span>
                                                            <?php if ($plan['id'] == $setting['free_plan']) { ?>
                                                                <span class="badge text-bg-warning ms-2">Free</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="notranslate"><?php echo $this->price($plan['price']); ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo (is_null($plan['words']) ? 'Unlimited' : $plan['words']); ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo (is_null($plan['images']) ? 'Unlimited' : $plan['images']); ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo $plan['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                                        <td class="text-end"><a class="text-decoration-none" href="<?php echo $this->url("admin/plans?edit=$plan[id]"); ?>">Edit</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (empty($monthly_plans)) { ?>
                            <div>Plan not available!</div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>