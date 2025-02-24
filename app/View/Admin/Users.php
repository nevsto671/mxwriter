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
                <?php if (isset($_GET['id']) && !empty($user)) { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-12 col-xl-8 offset-xl-1">
                            <?php if ($flash = $this->flash()) { ?>
                                <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                            <?php } ?>
                            <div class="card border-0 p-3">
                                <div class="mb-5">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <h3 class="fw-bold notranslate"><?php echo $user['name']; ?></h3>
                                            <?php if ($user['role'] == 1) { ?>
                                                <div class="ms-3"><span class="badge bg-success small">Admin</span></div>
                                            <?php } ?>
                                            <?php if ($user['status'] == 0) { ?>
                                                <div class="ms-3"><span class="badge bg-danger small">Account deactivated</span></div>
                                            <?php } ?>
                                        </div>
                                        <button type="button" class="btn-close" aria-label="Close" onclick="window.location.href='<?php echo $this->url('admin/users'); ?>'"></button>
                                    </div>
                                    <p class="mb-0">Join date: <?php echo date($this->setting['date_format'], strtotime($user['created'])); ?>, Email: <?php echo $user['email']; ?></p>
                                </div>
                                <?php if (isset($user['subscription_status']) && $user['subscription_status'] == 2) { ?>
                                    <div class="p-2 alert alert-warning mb-4">User subscription will automatically be canceled at the end of the current subscription period.</div>
                                <?php } ?>
                                <div class="row g-3 mb-5">
                                    <div class="col-6 col-md-3">
                                        <div class="card p-2 p-xl-3 h-100 shadow">
                                            <div class="fw-bold text-muted">Active plan</div>
                                            <div class="notranslate"><?php echo $plan_name; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="card p-2 p-xl-3 h-100 shadow">
                                            <div class="fw-bold text-muted">Plan expire</div>
                                            <div><?php echo !empty($expired) ? $expired : 'No'; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="card p-2 p-xl-3 h-100 shadow">
                                            <div class="fw-bold text-muted">Words left</div>
                                            <div><?php echo is_null($remaining_words) ? 'Unlimited' : $remaining_words; ?> words</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="card p-2 p-xl-3 h-100 shadow">
                                            <div class="fw-bold text-muted">Images left</div>
                                            <div><?php echo is_null($remaining_images) ? 'Unlimited' : $remaining_images; ?> Images</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add_plan">Add plan</button>
                                    <button type="button" class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#update_credits">Update credits</button>
                                    <?php if ($user['plan_id'] != 0 && $user['subscription_status'] == 1) { ?>
                                        <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#cancel_subscription">Cancel <span class="d-none d-md-inline">subscription</span></button>
                                    <?php } ?>
                                    <?php if ($user['role'] != 1) { ?>
                                        <button type="button" class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#change_role">Change role</button>
                                        <?php if ($user['status']) { ?>
                                            <button class="btn btn-sm btn-secondary me-2" onclick="if (confirm('Are you sure you want to deactivate this user?')) window.location.href='<?php echo $this->url('admin/users?deactivate=' . $user['id'] . '&sign=' . md5($user['id'])); ?>';">Deactivate account</button>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-secondary me-2" onclick="if (confirm('Are you sure you want to activate this user?')) window.location.href='<?php echo $this->url('admin/users?activate=' . $user['id'] . '&sign=' . md5($user['id'])); ?>';">Activate account</button>
                                        <?php } ?>
                                        <button class="btn btn-sm btn-danger me-2" onclick="if (confirm('Are you sure you want to permanently delete this user account?')) window.location.href='<?php echo $this->url('admin/users?delete=' . $user['id'] . '&sign=' . md5($user['id'])); ?>';">Delete account</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($pending_subscriptions) { ?>
                        <div class="row justify-content-center justify-content-lg-start mb-4">
                            <div class="col-12 col-xl-8 offset-xl-1">
                                <div class="card border-0 p-3">
                                    <h5 class="fw-bold mb-3">Pending subscriptions</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Invoice</th>
                                                    <th scope="col">Plan name</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Subscribed</th>
                                                    <th scope="col" class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pending_subscriptions as $subscription) { ?>
                                                    <tr>
                                                        <td class="notranslate">#<?php echo $subscription['id']; ?></td>
                                                        <td class="notranslate"><?php echo isset($subscription['plan_name']) ? $subscription['plan_name'] : 'Unknown'; ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'], strtotime($subscription['start'])); ?></td>
                                                        <td class="text-end">
                                                            <button type="button" class="btn btn-sm btn-success" onclick="if (confirm('Are you sure you want to active this subscription?')) window.location.href='<?php echo $this->url('admin/users?id=' . $subscription['user_id'] . '&invoice=' . $subscription['id'] . '&sign=' . md5($subscription['id'])); ?>';">Active plan</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($subscriptions) { ?>
                        <div class="row justify-content-center justify-content-lg-start mb-4">
                            <div class="col-12 col-xl-8 offset-xl-1">
                                <div class="card border-0 p-3">
                                    <h5 class="fw-bold mb-3">Last 5 subscription history</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Plan name</th>
                                                    <th scope="col">Subscribed</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Expiry date</th>
                                                    <th scope="col" class="text-end" style="width: 80px">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($subscriptions as $subscription) { ?>
                                                    <tr>
                                                        <td class="notranslate"><?php echo isset($subscription['plan_name']) ? $subscription['plan_name'] : 'Unknown'; ?></td>
                                                        <td><?php echo date($this->setting['date_format'], strtotime($subscription['start'])); ?></td>
                                                        <td class="d-none d-sm-table-cell"><?php echo !is_null($subscription['end']) ? date($this->setting['date_format'], strtotime($subscription['end'])) : '-'; ?></td>
                                                        <td class="text-end"><?php echo $subscription['status'] == 2 ? "Pending" : ($subscription['status'] == 1 ? "Active" : "Expired"); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($transactions) { ?>
                        <div class="row justify-content-center justify-content-lg-start mb-4">
                            <div class="col-12 col-xl-8 offset-xl-1">
                                <div class="card border-0 p-3">
                                    <h5 class="fw-bold mb-3">Last 5 transaction history</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="d-none d-sm-table-cell">Trx ID</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col" class="d-none d-sm-table-cell">Method</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col" class="text-end" style="width: 80px">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($transactions as $transaction) { ?>
                                                    <tr>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo $transaction['id']; ?></td>
                                                        <td><?php echo date($this->setting['date_format'], strtotime($transaction['created'])); ?></td>
                                                        <td class="d-none d-sm-table-cell notranslate"><?php echo $transaction['method']; ?></td>
                                                        <td class="notranslate"><?php echo $this->price($transaction['amount']); ?></td>
                                                        <td class="text-end"><?php echo $transaction['payment_status'] == 1 ? 'Paid' : ($transaction['payment_status'] == 2 ? "Pending" : "Unpaid"); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="modal modal-sm fade" id="add_plan" tabindex="-1" aria-labelledby="add plan" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Add Plan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="form" novalidate>
                                        <div class="mb-4">
                                            <select name="plan_id" class="form-select" required>
                                                <option value="" selected disabled>Select plan</option>
                                                <?php foreach ($plans as $plan) {
                                                    if ($plan['duration'] != 'prepaid') { ?>
                                                        <option translate="no" value="<?php echo $plan['id']; ?>"><?php echo $plan['name']; ?> - <?php echo $this->price($plan['price']); ?><?php echo $plan['duration'] != 'prepaid' ? "/$plan[duration]" : null; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="py-2">
                                            <button type="submit" class="btn btn-primary w-100" data-loader="Saving...">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal modal-sm fade" id="update_credits" tabindex="-1" aria-labelledby="update credits" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Update Credits</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="form" novalidate>
                                        <div class="mb-4">
                                            <label class="form-label text-muted">Expiry date</label>
                                            <div class="input-group">
                                                <select name="expiry_day" class="form-select">
                                                    <?php $start_date = 1;
                                                    $end_date = 31;
                                                    for ($j = $start_date; $j <= $end_date; $j++) {
                                                        $d = sprintf("%02d", $j);
                                                        echo '<option value=' . $d . '' . ($d == $expiry_day ? ' selected' : null) . '>' . $d . '</option>';
                                                    } ?>
                                                </select>
                                                <select name="expiry_month" class="form-select">
                                                    <?php for ($m = 1; $m <= 12; ++$m) {
                                                        $ms = date('M', mktime(0, 0, 0, $m, 1));
                                                        $mi = date('m', mktime(0, 0, 0, $m, 1));
                                                        echo '<option value="' . $mi . '" ' . ($mi == $expiry_month ? ' selected' : null) . '>' . $ms . '</option>';
                                                    } ?>
                                                </select>
                                                <select name="expiry_year" class="form-select">
                                                    <option value="">No Expiry</option>
                                                    <?php $year = date('Y');
                                                    $min = $year;
                                                    $max = $year + 5;
                                                    for ($i = $max; $i >= $min; $i--) {
                                                        echo '<option value=' . $i . '' . ($i == $expiry_year ? ' selected' : null) . '>' . $i . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label text-muted">Words generate</label>
                                            <input type="text" name="words" class="form-control" minlength="1" placeholder="Enter total words" value="<?php echo $remaining_words; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label text-muted">Images generate</label>
                                            <input type="text" name="images" class="form-control" minlength="1" placeholder="Enter total images" value="<?php echo $remaining_images; ?>" onkeypress="return /[0-9]/i.test(event.key)">
                                        </div>
                                        <div class="py-2">
                                            <button type="submit" class="btn btn-primary w-100" data-loader="Updating...">Save changes</button>
                                        </div>
                                        <div class="small text-muted text-center">Make blank field for unlimited credits</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal modal-sm fade" id="cancel_subscription" tabindex="-1" aria-labelledby="add plan" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Cancel subscription</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p class="mb-4">If you cancel your subscription, you can continue to use the plan benefits and remaining credits until the end of your current subscription period. You can also resubscribe at any time.</p>
                                    <div class="py-2">
                                        <a class="btn btn-danger w-100" href="<?php echo $this->url('admin/users?id=' . (isset($subscription['user_id']) ? $subscription['user_id'] : null) . '&cancel=' . md5(date('H'))); ?>" onclick="return confirm('Are you sure you want to cancel this user subscription?');">Cancel <span class="d-none d-sm-inline">subscription</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal modal-sm fade" id="change_role" tabindex="-1" aria-labelledby="add plan" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Change user role</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="form" novalidate>
                                        <div class="mb-5">
                                            <select name="role" class="form-select notranslate" required>
                                                <option value="0" <?php echo $user['role'] == 0 ? 'selected' : null; ?>>User</option>
                                                <option value="1" <?php echo $user['role'] == 1 ? 'selected' : null; ?>>Admin</option>
                                            </select>
                                        </div>
                                        <div class="py-2">
                                            <button type="submit" class="btn btn-primary w-100" data-loader="Saving...">Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="d-md-flex justify-content-between">
                        <h2 class="fw-bold mb-4">Users</h2>
                        <div class="d-flex mb-2 mb-md-0">
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end px-2 py-0" style="min-width: auto;">
                                        <li><a class="dropdown-item py-1" href="<?php echo $this->url("admin/users?plan=all"); ?>">All plan</a></li>
                                        <?php foreach ($plans as $plan) {
                                            if ($plan['duration'] != 'prepaid') { ?>
                                                <li><a class="dropdown-item py-1" href="<?php echo $this->url("admin/users?plan=$plan[id]"); ?>"><?php echo $plan['name']; ?></a></li>
                                        <?php }
                                        } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="ms-2">
                                <button type="button" class="btn btn-light" title="Add new user" data-bs-toggle="modal" data-bs-target="#add_user">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M16 19h6" />
                                        <path d="M19 16v6" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                    </svg><span class="ms-2">Add user</span>
                                </button>
                            </div>
                            <div class="ms-2">
                                <button type="button" class="btn btn-light" title="Download all user" onclick="if (confirm('Are you sure you want to export all user?')) window.location.href='<?php echo $this->url('admin/users?export=' . $this->token); ?>';">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                        <path d="M7 11l5 5l5 -5" />
                                        <path d="M12 4l0 12" />
                                    </svg><span class="ms-2">Export</span>
                                </button>
                            </div>
                            <div class="ms-2">
                                <form method="get" action="<?php echo $this->url("admin/users"); ?>">
                                    <div class="input-group border rounded">
                                        <input type="text" name="search" class="form-control py-0 border-0 shadow-none" value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search'] : null; ?>" placeholder="Search...">
                                        <button type="submit" class="btn border-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#999" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php if ($flash = $this->flash()) { ?>
                        <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                    <?php } ?>
                    <div class="mb-4">
                        <?php if ($users) { ?>
                            <div class="card border-0 p-3 mb-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">User name</th>
                                                <th scope="col" class="d-none d-md-table-cell">Email</th>
                                                <th scope="col" class="d-none d-sm-table-cell">Join date</th>
                                                <th scope="col">Active plan</th>
                                                <th scope="col" class="d-none d-sm-table-cell">Status</th>
                                                <th scope="col" class="text-end" style="width: 20px">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user) { ?>
                                                <tr>
                                                    <td class="notranslate"><?php echo $user['name']; ?></td>
                                                    <td class="notranslate d-none d-md-table-cell <?php echo $user['status'] == 2 ? 'text-muted' : null; ?>"><?php echo $user['email']; ?></td>
                                                    <td class="d-none d-sm-table-cell"><?php echo date($this->setting['date_format'], strtotime($user['created'])); ?></td>
                                                    <td class="notranslate"><?php echo isset($user['plan_name']) ? $user['plan_name'] : 'Free'; ?></td>
                                                    <td class="d-none d-sm-table-cell"><?php echo $user['status'] == 0 ? '<span class="badge bg-danger">Deactivate</span>' : '<span class="badge bg-success">Active</span>'; ?></td>
                                                    <td class="text-end">
                                                        <a class="text-decoration-none" href="<?php echo $this->url("admin/users?id=$user[id]"); ?>">View</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php if (empty($_GET['search'])) { ?>
                                <nav class="my-4"><?php echo $pagination; ?></nav>
                                <div>Total users: <?php echo $total; ?></div>
                            <?php } ?>
                        <?php } else { ?>
                            <div>User not found!</div>
                        <?php } ?>
                    </div>
                    <div class="modal modal-sm fade" id="add_user" tabindex="-1" aria-labelledby="add user" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Add new user</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="form" novalidate>
                                        <div class="mb-4">
                                            <label for="name-input" class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" id="name-input" placeholder="Full name" minlength="4" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="email-input" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="email-input" placeholder="Email address" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Active plan</label>
                                            <select name="plan_id" class="form-select">
                                                <option value="" selected>Default plan</option>
                                                <option value="0">No plan</option>
                                                <?php foreach ($plans as $plan) { ?>
                                                    <option value="<?php echo $plan['id']; ?>"><?php echo $plan['name']; ?> - <?php echo $this->price($plan['price']); ?><?php echo $plan['duration'] != 'prepaid' ? "/$plan[duration]" : null; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="py-2">
                                            <button type="submit" class="btn btn-primary w-100" data-loader="Saving...">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>