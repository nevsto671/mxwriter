<!doctype html>
<html lang="<?php echo $this->setting['direction'] == 'rtl' ? 'ar' : 'en'; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
    <?php require_once APP . '/View/User/Head.php'; ?>
    <link href="<?php echo $this->url('assets/css/summernote-bs5.min.css'); ?>" rel="stylesheet" type="text/css">
</head>

<body>
    <?php require_once APP . '/View/Admin/Header.php'; ?>
    <main>
        <div class="container-fluid">
            <?php require_once APP . '/View/Admin/Sidebar.php'; ?>
            <div class="main">
                <?php if (isset($_GET['add'])) { ?>
                    <div class="card border-0 p-3">
                        <h5 class="fw-bold mb-4">Add page</h5>
                        <form method="post" class="form">
                            <div class="mb-4">
                                <label for="name-input" class="form-label text-muted">Name</label>
                                <input type="text" name="name" class="form-control" id="name-input" minlength="3" required>
                            </div>
                            <div class="mb-4">
                                <label for="name-input" class="form-label text-muted">Title</label>
                                <input type="text" name="title" class="form-control" id="name-input" minlength="3">
                            </div>
                            <div class="mb-4 notranslate">
                                <textarea name="description" class="form-control summernote" id="summernote" rows="14"></textarea>
                            </div>
                            <div class="mb-4 d-flex justify-content-between">
                                <div class="form-check">
                                    <input type="checkbox" name="status" class="form-check-input" id="input-status" value="" checked>
                                    <label class="form-check-label" for="input-status">Active and Publish</label>
                                </div>
                            </div>
                            <div class="text-start">
                                <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                <a href="<?php echo $this->url("admin/pages"); ?>" class="btn btn-light ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                <?php } else if (!empty($page['id'])) { ?>
                    <div class="card border-0 p-3">
                        <h5 class="fw-bold mb-4"><?php echo $page['name']; ?></h5>
                        <form method="post">
                            <div class="mb-4">
                                <label for="name-input" class="form-label text-muted">Title</label>
                                <input type="text" name="title" class="form-control" id="name-input" minlength="3" value="<?php echo $page['title']; ?>">
                            </div>
                            <div class="mb-4 notranslate">
                                <textarea name="description" class="form-control summernote" id="summernote" rows="14"><?php echo $page['description']; ?></textarea>
                            </div>
                            <div class="mb-4 d-flex justify-content-between">
                                <div class="form-check">
                                    <input type="checkbox" name="status" class="form-check-input" id="input-status" value="" <?php echo $page['status'] == 1 ? 'checked' : null; ?>>
                                    <label class="form-check-label" for="input-status">Active and Publish</label>
                                </div>
                                <?php if ($page['deletable']) { ?>
                                    <button type="button" class="btn p-0" title="Delete" onclick="if (confirm('Are you sure you want to delete this page?')) window.location.href='<?php echo $this->url('admin/pages?delete=' . $page['id'] . '&sign=' . md5($page['id'])); ?>';">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </button>
                                <?php } ?>
                            </div>
                            <div class="text-start">
                                <button type="submit" class="btn btn-primary" data-loader="Saving...">Save changes</button>
                                <a href="<?php echo $this->url("admin/pages"); ?>" class="btn btn-light ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                <?php } else { ?>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold mb-4">Pages</h2>
                            <div>
                                <a class="btn btn-primary" href="<?php echo $this->url("admin/pages?add"); ?>">Add new page</a>
                            </div>
                        </div>
                        <?php if ($flash = $this->flash()) { ?>
                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                        <?php } ?>
                        <div class="card border-0 p-3 mb-3">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col" class="d-none d-sm-table-cell">Title</th>
                                            <th scope="col" class="text-end">Status</th>
                                            <th scope="col" class="text-end" style="width: 80px">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pages as $page) { ?>
                                            <tr>
                                                <td><a class="text-dark text-decoration-none hover-blue" href="<?php echo $this->url("$page[slug]"); ?>" target="_blank"><?php echo $page['name']; ?></a></td>
                                                <td class="d-none d-sm-table-cell"><?php echo $page['title']; ?></td>
                                                <td class="text-end"><?php echo $page['status'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                                <td class="text-end"><a class="text-decoration-none" href="<?php echo $this->url("admin/pages?edit=$page[id]"); ?>">Edit</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
    <script src="<?php echo $this->url('assets/js/summernote-bs5.min.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                minHeight: 400,
                maxHeight: 400
            });
            $(".note-btn.dropdown-toggle").on("click", function() {
                $(this).dropdown('toggle');
            });
            $(".note-editable, .note-dropdown-menu .dropdown-item").on("click", function() {
                $(".note-btn.dropdown-toggle").dropdown('hide');
            });
        });
    </script>
</body>

</html>