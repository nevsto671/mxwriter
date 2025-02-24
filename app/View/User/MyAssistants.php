<!doctype html>
<html lang="<?php echo $this->setting['direction'] == 'rtl' ? 'ar' : 'en'; ?>" dir="<?php echo $this->setting['direction']; ?>" data-bs-theme="<?php echo $this->setting['theme_style']; ?>">

<head>
    <?php require_once APP . '/View/User/Head.php'; ?>
    <link href="<?php echo $this->url('assets/css/summernote-bs5.min.css'); ?>" rel="stylesheet" type="text/css">
</head>

<body>
    <?php require_once APP . '/View/User/Header.php'; ?>
    <main>
        <div class="container-fluid">
            <?php require_once APP . '/View/User/Sidebar.php'; ?>
            <div class="main">
                <?php if (isset($_GET['create']) || !empty($assistant)) { ?>
                    <div class="col-xl-10 offset-xl-1 mb-5" style="max-width: 960px;">
                        <?php if ($flash = $this->flash()) { ?>
                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                        <?php } ?>
                        <div class="card p-3">
                            <form method="post" class="form form-group" novalidate>
                                <div class="mb-4 text-center" id="thumbnail">
                                    <div class="upload_error p-2 alert alert-danger" style="display: none;"></div>
                                    <div class="input-file-thumbnail">
                                        <img class="img-thumbnail rounded-pill" src="<?php echo !empty($assistant['thumbnail']) ? $assistant['thumbnail'] : $this->url('assets/img/placeholder.jpg'); ?>" data-src="<?php echo $this->url('assets/img/placeholder.jpg'); ?>" width="120" height="120">
                                    </div>
                                    <input type="file" name="thumbnail" class="input-file" style="display: none" accept=".jpeg,.jpg,.png,.webp" data-preload="true">
                                    <input type="hidden" name="thumbnail" class="input-file-url" value="<?php echo !empty($assistant['thumbnail']) ? $assistant['thumbnail'] : null; ?>">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-light input-file-button" data-upload="image" data-target="#thumbnail" style="display: <?php echo !empty($assistant['thumbnail']) ? 'none' : 'inline';  ?>">Add</button>
                                        <?php if (!empty($assistant['thumbnail'])) { ?>
                                            <button type="button" class="btn btn-sm btn-light" id="deleteImage">Remove</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row gy-3 mb-4">
                                    <div class="col-12 col-md-6">
                                        <label for="name-input" class="form-label text-muted">Name</label>
                                        <input type="text" name="name" class="form-control" id="name-input" value="<?php echo isset($assistant['name']) ? $assistant['name'] : null; ?>" placeholder="e.g. SEO" minlength="2" maxlength="40" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Model</label>
                                        <select name="model" class="form-select">
                                            <option value="" selected disabled>Select model</option>
                                            <?php foreach ($models as $model) { ?>
                                                <option value="<?php echo $model['model']; ?>" <?php echo isset($assistant['model']) && ($assistant['model']) == $model['model']  ? 'selected' : (isset($chat_model) && $chat_model == $model['model'] ? 'selected' : null); ?>><?php echo $model['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="name-role" class="form-label text-muted">Role (optional)</label>
                                        <input type="text" name="role" class="form-control" id="name-role" value="<?php echo isset($assistant['role']) ? $assistant['role'] : null; ?>" placeholder="e.g. SEO Specialist" minlength="2" maxlength="40">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label text-muted small">Group (optional)</label>
                                        <input type="text" name="group_name" class="form-control" minlength="2" maxlength="50" placeholder="e.g. Website" minlength="2" maxlength="40" value="<?php echo isset($assistant['group_name']) ? $assistant['group_name'] : null; ?>">
                                    </div>
                                </div>
                                <div class="mb-4 notranslate">
                                    <label class="form-label text-muted" translate="yes">Introduction</label>
                                    <textarea name="introduction" class="form-control notranslate summernote" rows="6" placeholder="e.g. Hello! I'm here to assist you with any SEO-related questions or information you might need."><?php echo isset($assistant['introduction']) ? $assistant['introduction'] : null; ?></textarea>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label text-muted">Instructions</label>
                                    <textarea name="prompt" class="form-control notranslate autosize" rows="8" minlength="10" placeholder="e.g. I want you to act as a search engine optimization specialist. Ignore if it is not SEO-related."><?php echo isset($assistant['prompt']) ? $assistant['prompt'] : null; ?></textarea>
                                </div>
                                <div class="mb-5">
                                    <h6 class="fw-bold mb-3">Knowledge</h6>
                                    <div class="mb-4" id="fileHistory">
                                        <div class="row g-3" id="fileList">
                                            <?php foreach (!empty($files) ? $files : [] as $val) {
                                                $extension = pathinfo($val['name'], PATHINFO_EXTENSION); ?>
                                                <div class="col-12 col-md-6 col-xxl-4" id="<?php echo $val['id']; ?>">
                                                    <div class="card p-2 border shadow-none bg-transparent">
                                                        <div class="d-flex">
                                                            <div>
                                                                <div class="rounded text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; background-color: #fc5d92;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                                        <path d="M9 9l1 0" />
                                                                        <path d="M9 13l6 0" />
                                                                        <path d="M9 17l6 0" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-between ms-2 w-100 text-truncate">
                                                                <div class="text-truncate">
                                                                    <div class="fw-semibold text-truncate mb-1"><?php echo htmlspecialchars($val['name']); ?></div>
                                                                    <div class="text-muted small text-uppercase fileExtension"><?php echo !empty($extension) ? $extension : null; ?></div>
                                                                </div>
                                                                <div class="pt-1 ms-2 delete-button" style="display: none;">
                                                                    <button type="button" class="dropdown-item m-0 d-flex align-items-center deleteFile" data-id="<?php echo $val['id']; ?>" data-bs-toggle="modal" data-bs-target="#deleteFile">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M4 7l16 0" />
                                                                            <path d="M10 11l0 6" />
                                                                            <path d="M14 11l0 6" />
                                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-12 col-md-6 col-xxl-4" id="fileItem" style="display: none;">
                                                <div class="card p-2 border shadow-none bg-transparent">
                                                    <div class="d-flex">
                                                        <div>
                                                            <div class="rounded text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; background-color: #fc5d92;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                                    <path d="M9 9l1 0" />
                                                                    <path d="M9 13l6 0" />
                                                                    <path d="M9 17l6 0" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between ms-2 w-100 text-truncate">
                                                            <div class="text-truncate">
                                                                <div class="fw-bold text-truncate pt-1 mb-1 fileName"></div>
                                                                <div class="text-muted small text-uppercase fileExtension"></div>
                                                            </div>
                                                            <div class="pt-1 ms-2 delete-button" style="display: none;">
                                                                <button type="button" class="dropdown-item m-0 d-flex align-items-center deleteFile" data-id="" data-bs-toggle="modal" data-bs-target="#deleteFile">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M4 7l16 0" />
                                                                        <path d="M10 11l0 6" />
                                                                        <path d="M14 11l0 6" />
                                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="deleteFile" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm z-3">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">Remove file</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="mt-3 mb-4 text-center">Are you sure you want to remove this file?</h6>
                                                        <div class="py-2">
                                                            <button type="button" class="btn btn-danger w-100" id="fileDeleteId" data-bs-dismiss="modal" data-loader="">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div id="uploadError" class="alert alert-danger py-2 mb-4" style="display: none;">Something went wrong. Please try again.</div>
                                        <div id="UploadProgress" class="progress mb-3" style="display: none;">
                                            <div id="progressBar" class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                        </div>
                                        <button type="button" id="fileUploadButton" class="btn border" aria-label="file">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                <path fill="currentColor" fill-rule="evenodd" d="M9 7a5 5 0 0 1 10 0v8a7 7 0 1 1-14 0V9a1 1 0 0 1 2 0v6a5 5 0 0 0 10 0V7a3 3 0 1 0-6 0v8a1 1 0 1 0 2 0V9a1 1 0 1 1 2 0v6a3 3 0 1 1-6 0z" clip-rule="evenodd"></path>
                                            </svg><span class="ms-2">Upload files</span>
                                        </button>
                                        <input type="file" id="fileUpload" name="files" style="display: none" accept=".c,.cs,.cpp,.doc,.docx,.html,.htm,.java,.json,.md,.pdf,.php,.pptx,.py,.py,.rb,.tex,.txt,.css,.js,.sh,.ts" multiple>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="status" class="form-check-input" id="input-status" value="" <?php echo isset($assistant['status']) ? ($assistant['status'] == 1 ? 'checked' : null) : 'checked'; ?>>
                                        <label class="form-check-label" for="input-status">Active and Publish</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="submit" class="btn btn-primary px-4" id="submitButton" data-loader="Saving...">Save details</button>
                                    </div>
                                    <div>
                                        <?php if (!empty($assistant)) { ?>
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
                                        <h6 class="mt-3 mb-4 text-center">Are you sure you want to delete this assistant?</h6>
                                        <div class="py-2">
                                            <input type="hidden" name="delete_assistant" value="<?php echo !empty($assistant['id']) ? md5($assistant['id']) : null; ?>">
                                            <button type="submit" class="btn btn-danger w-100" data-loader="Deleting...">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold mb-4">My Assistants</h2>
                            <div>
                                <a class="btn btn-primary <?php echo empty($assistant_access) ? "disabled" : null; ?>" href="<?php echo $this->url("my/chat/assistants?create"); ?>">Add assistant</a>
                            </div>
                        </div>
                        <?php if ($flash = $this->flash()) { ?>
                            <div class="p-2 alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
                        <?php } ?>
                        <?php if (empty($this->plan['my_assistant'])) { ?>
                            <div class="alert alert-warning text-center">To access this feature, please upgrade your current plan.</div>
                        <?php } else if (empty($assistant_access)) { ?>
                            <div class="alert alert-warning text-center">You have exhausted your assistant creation credits. Please upgrade your plan to create more assistants.</div>
                        <?php } ?>
                        <?php if (!empty($assistants)) { ?>
                            <div class="card p-3 mb-3">
                                <form method="post" class="form form-group">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 60px;">Image</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Role</th>
                                                    <th scope="col">Group</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col" class="text-end" style="width: 50px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($assistants as $assistant) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="mb-2 img-thumbnail rounded-pill d-flex justify-content-center align-items-center mx-auto" style="width: 32px; height: 32px;">
                                                                <?php if (!empty($assistant['thumbnail'])) { ?>
                                                                    <img class="rounded-circle" src="<?php echo $assistant['thumbnail']; ?>" width="32" height="32">
                                                                <?php } else { ?>
                                                                    <div class="chat-user fw-semibold m-0"><?php echo !empty($assistant['name']) ? mb_substr($assistant['name'], 0, 1) : 'A'; ?></div>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                        <td class="fw-semibold"><?php echo $assistant['name']; ?></td>
                                                        <td><?php echo $assistant['role'] ? $assistant['role'] : null; ?></td>
                                                        <td><?php echo $assistant['group_name'] ? $assistant['group_name'] : '-'; ?></td>
                                                        <td><?php echo $assistant['status'] ? 'Active' : '<span class="text-danger">Inactive</span>'; ?></td>
                                                        <td class="text-end">
                                                            <a href="<?php echo $this->url("my/chat/assistants?id=" . base64_encode($assistant['id'])); ?>" class="text-decoration-none" title="Edit">Edit</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <nav class="my-4"><?php echo $pagination; ?></nav>
                        <?php } else { ?>
                            <div>You have not added any assistant yet.</div>
                        <?php } ?>
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
                minHeight: 120,
                maxHeight: 400,
                tooltip: false,
                toolbar: [
                    ['style', ['style', 'bold', 'fontsize', 'align', 'paragraph', 'ul', 'ol', 'codeview']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).parents('.response-message').find('.ai-content').html(contents);
                    }
                }
            });

            $("#deleteImage").on("click", function() {
                $(this).parents('#thumbnail').find('.input-file-url').val('');
                $(this).parents('#thumbnail').find('img').attr('src', $(this).parents('#thumbnail').find('img').data('src'));
                $('.input-file-button').show();
                $(this).hide();
            });

            $(".note-btn.dropdown-toggle").on("click", function() {
                $(this).dropdown('toggle');
            });

            $(".note-editable, .note-dropdown-menu .dropdown-item").on("click", function() {
                $(".note-btn.dropdown-toggle").dropdown('hide');
            });

            $('#fileUpload').change(function() {
                var files = this.files;
                if (files.length > 0) {
                    var formData = new FormData();
                    for (var i = 0; i < files.length; i++) {
                        formData.append('files[]', files[i]);
                    }
                    $('#uploadError').hide();
                    $('#UploadProgress').show();
                    $('#UploadLoader').show();
                    $('#fileHistory').show();
                    $('#fileUploadButton').prop('disabled', true);
                    $('#submitButton').prop('disabled', true);
                    $.ajax({
                        url: '',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    percentComplete = Math.min(Math.round(percentComplete), 99);
                                    $('#progressBar').width(percentComplete + '%');
                                    $('#progressBar').html(percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(response) {
                            if (response && typeof response === 'object') {
                                if (response.files && Array.isArray(response.files)) {
                                    response.files.forEach(function(file) {
                                        var newItem = $('#fileItem').clone().show();
                                        newItem.find('.fileName').text(file.fileName);
                                        newItem.find('.fileExtension').text(file.fileExtension);
                                        newItem.find('.deleteFile').attr('data-id', file.fileId);
                                        newItem.attr('id', file.fileId);
                                        $('#fileItem').before(newItem);
                                    });

                                } else if (response.error) {
                                    $('#uploadError').html(response.error).show();
                                }
                                $('#fileUploadButton').show();
                                $('#UploadLoader').hide();
                                $('#UploadProgress').hide();
                                $('#progressBar').width('0%');
                                $('#progressBar').html('');
                            } else {
                                $('#uploadError').show();
                                $('#fileUploadButton').show();
                                $('#UploadProgress').hide();
                                $('#UploadLoader').hide();
                            }
                        },
                        complete: function() {
                            $('#fileUploadButton').val('');
                            $('#fileUploadButton').prop('disabled', false);
                            $('#submitButton').prop('disabled', false);
                        },
                        error: function() {
                            $('#uploadError').show();
                            $('#fileUploadButton').show();
                            $('#UploadProgress').hide();
                            $('#UploadLoader').hide();
                            $('#submitButton').prop('disabled', false);
                        }
                    });
                }
            });

            $('#fileUploadButton').click(function() {
                $('#fileUpload').click();
            });

            $(document).on("click", ".deleteFile", function(e) {
                var id = $(this).data('id');
                $('#fileDeleteId').attr('data-id', id);
            });

            $(document).on("click", "#fileDeleteId", function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $('#' + id).hide();
                $.post("", {
                    delete_file_id: id
                });
            });
        });
    </script>
</body>

</html>