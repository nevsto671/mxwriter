<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
    <?php require_once APP . '/View/User/Head.php'; ?>
</head>

<body>
    <?php require_once APP . '/View/User/Header.php'; ?>
    <main>
        <div class="container-fluid">
            <?php require_once APP . '/View/User/Sidebar.php'; ?>
            <div class="main">
                <?php if (isset($_GET['create']) || !empty($brand)) { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-lg-12 col-xl-10 col-xxl-7 offset-xl-1">
                            <div class="d-sm-flex justify-content-between mb-4">
                                <h2 class="fw-bold mb-3 mb-sm-0">Brand Voice</h2>
                                <div>
                                </div>
                            </div>
                            <div class="card border-0 p-3">
                                <form method="post" class="form validation" novalidate>
                                    <div class="row mb-4">
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label fw-semibold">Brand Name</label>
                                            <input type="text" name="name" class="form-control" minlength="2" value="<?php echo isset($brand['name']) ? $brand['name'] : null; ?>" required>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label fw-semibold">Industry / Category</label>
                                            <input type="text" name="industry" class="form-control" value="<?php echo isset($brand['industry']) ? $brand['industry'] : null; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label fw-semibold">Tagline / Mission</label>
                                            <input type="text" name="tagline" class="form-control" value="<?php echo isset($brand['tagline']) ? $brand['tagline'] : null; ?>">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label fw-semibold">Website Link</label>
                                            <input type="text" name="website" class="form-control" value="<?php echo !empty($brand['website']) ? htmlspecialchars($brand['website'], ENT_QUOTES, 'UTF-8') : null; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Target Audience</label>
                                            <input type="text" name="audience" class="form-control" value="<?php echo isset($brand['audience']) ? $brand['audience'] : null; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Brand / Company Description</label>
                                        <textarea name="description" class="form-control" rows="10" required><?php echo isset($brand['description']) ? $brand['description'] : null; ?></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button type="submit" class="btn btn-primary px-4" data-loader="Saving...">Save details</button>
                                        </div>
                                        <div>
                                            <?php if (!empty($brand)) { ?>
                                                <button type="button" class="btn btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal fade" id="delete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered z-3">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Delete</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" class="form" novalidate>
                                            <h6 class="mt-3 mb-4 text-center">Are you sure you want to delete this brand?</h6>
                                            <div class="py-2">
                                                <input type="hidden" name="delete_brand" value="<?php echo !empty($brand['id']) ? md5($brand['id']) : null; ?>">
                                                <button type="submit" class="btn btn-danger w-100" data-loader="Deleting...">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row justify-content-center justify-content-lg-start mb-4">
                        <div class="col-lg-12 col-xl-10 col-xxl-7 offset-xl-1">
                            <div class="d-sm-flex justify-content-between mb-4">
                                <h2 class="fw-bold mb-3 mb-sm-0">Brand Voice</h2>
                                <div>
                                    <a class="btn btn-light <?php echo empty($plan['brand']) ? "disabled" : null; ?>" href="<?php echo $this->url("my/brands?create"); ?>">Add New Brand</a>
                                </div>
                            </div>
                            <?php if ($flash = $this->flash()) { ?>
                                <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                            <?php } ?>
                            <?php if (!empty($plan['brand'])) { ?>
                                <?php if (!empty($brands)) { ?>
                                    <div class="card border-0 p-3">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Brand Name</th>
                                                        <th scope="col" class="d-none d-md-table-cell">Industry</th>
                                                        <th scope="col" class="text-end" style="width: 50px"><span class="d-none d-md-inline">Edit</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($brands as $brand) { ?>
                                                        <tr>
                                                            <td><?php echo $brand['name']; ?></td>
                                                            <td><?php echo $brand['industry']; ?></td>
                                                            <td class="text-end">
                                                                <a class="text-decoration-none" href="<?php echo $this->url("my/brands?id=$brand[id]"); ?>">Edit</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div>
                                        You haven't added any brand yet.
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="alert alert-warning text-center">To access this feature, please upgrade your current plan.</div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>