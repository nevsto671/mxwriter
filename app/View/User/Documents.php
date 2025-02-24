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
                <div class="d-sm-flex justify-content-between mb-4">
                    <h2 class="fw-bold mb-3 mb-sm-0">Documents</h2>
                    <div>
                        <form method="get" action="<?php echo $this->url("my/documents"); ?>">
                            <div class="input-group border rounded">
                                <input type="text" name="search" class="form-control border-0 shadow-none" value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search'] : null; ?>" placeholder="Search...">
                                <button type="submit" class="btn border-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#999" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if ($doc_over) { ?>
                    <div class="py-2 alert alert-warning">Sorry, You have exhausted your documents credits in current plan. Upgrade your subscription plan or delete existing documents to create new.</div>
                <?php } ?>
                <?php if ($documents) { ?>
                    <div class="card border-0 p-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-end d-none d-md-table-cell" style="width: 150px"></th>
                                        <th scope="col" class="text-end" style="width: 40px"></th>
                                        <th scope="col" class="text-end" style="width: 40px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($documents as $document) { ?>
                                        <tr>
                                            <td>
                                                <a class="text-dark text-decoration-none hover-blue d-flex align-items-center" href="<?php echo $this->url("my/editor?d=$document[id]&r=documents"); ?>">
                                                    <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description" width="22" height="22" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                            <path d="M9 17h6" />
                                                            <path d="M9 13h6" />
                                                        </svg>
                                                    </div>
                                                    <span class="ms-3 doc_name notranslate" id="name_<?php echo $document['id']; ?>"><?php echo $document['name'] ?: 'New Document'; ?></span>
                                                </a>
                                            </td>
                                            <td class="text-end d-none d-md-table-cell"><?php echo date($this->setting['date_format'], strtotime($document['modified'])); ?></td>
                                            <td class="text-end">
                                                <button type="button" class="btn p-0 border-0 shadow-none rename_doc" title="Rename" data-bs-toggle="modal" data-bs-target="#rename" data-id="<?php echo $document['id']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                        <path d="M13.5 6.5l4 4" />
                                                        <path d="M16 19h6" />
                                                    </svg>
                                                </button>
                                            </td>
                                            <td class="text-end">
                                                <button type="button" class="btn p-0 border-0 shadow-none delete_doc" title="Delete" data-id="<?php echo $document['id']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <nav class="my-4"><?php echo $pagination; ?></nav>
                    <div class="modal fade modal-sm" id="rename" tabindex="-1" aria-labelledby="Rename" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Rename</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="form" novalidate>
                                        <div class="mb-4">
                                            <label class="form-label text-muted">Document name</label>
                                            <input type="text" name="name" class="form-control" minlength="3" maxlength="150" placeholder="e.g. New document" required>
                                        </div>
                                        <div class="py-2">
                                            <button type="submit" class="btn btn-primary w-100" id="rename_doc" data-bs-dismiss="modal" data-loader="Saving...">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="py-4">
                        <?php if (!empty($_GET['search']) && is_string($_GET['search'])) { ?>
                            <h5 class="fw-normal">No documents found in your search.</h5>
                        <?php } else { ?>
                            <h5 class="fw-normal">You haven't saved any document yet.</h5>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>