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
                    <h2 class="fw-bold mb-3 mb-sm-0">My History</h2>
                    <div>
                        <form method="get" action="<?php echo $this->url("my/history"); ?>">
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
                <?php if ($history) { ?>
                    <div class="card border-0 p-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Use case</th>
                                        <th scope="col" class="text-end d-none d-md-table-cell" style="width: 120px"></th>
                                        <th scope="col" class="text-end d-none d-md-table-cell" style="width: 150px"></th>
                                        <th scope="col" class="text-end" style="width: 40px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history as $val) {
                                        $data = !empty($val['data']) ? json_decode($val['data'], true) : []; ?>
                                        <tr>
                                            <td>
                                                <a class="text-dark text-decoration-none hover-blue d-flex" href="<?php echo $this->url("my/editor?h=$val[id]&r=history"); ?>">
                                                    <span class="d-block">
                                                        <span class="rounded text-white mt-1 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px; background-color: <?php echo !empty($val['color']) ? $val['color'] : '#f4ac36'; ?>;">
                                                            <?php if (!empty($val['icon'])) {
                                                                echo $val['icon'];
                                                            } else { ?>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                                                    <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                                                                    <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                                                </svg>
                                                            <?php } ?>
                                                        </span>
                                                    </span>
                                                    <span class="d-block ms-3 notranslate">
                                                        <span class="d-block mb-1"><?php echo !empty($val['title']) ? $val['title'] : 'Unknown'; ?></span>
                                                        <?php foreach ($data as $v) { ?>
                                                            <span class="small d-block text-muted"><?php echo $v['data']; ?></span>
                                                        <?php } ?>
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="text-end d-none d-md-table-cell"><?php echo $val['language']; ?></td>
                                            <td class="text-end d-none d-md-table-cell"><?php echo date($this->setting['date_format'], strtotime($val['created'])); ?></td>
                                            <td class="text-end">
                                                <button type="button" class="btn p-0 border-0 shadow-none remove-history" title="Delete" data-id="<?php echo $val['id']; ?>">
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
                    <div class="mt-2 text-center">Please note that any history older than 30 days will be automatically deleted.</div>
                <?php } else { ?>
                    <div class="py-4">
                        <?php if (!empty($_GET['search']) && is_string($_GET['search'])) { ?>
                            <h5 class="fw-normal">No history found in your search.</h5>
                        <?php } else { ?>
                            <h5 class="fw-normal">History not available!</h5>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
</body>

</html>