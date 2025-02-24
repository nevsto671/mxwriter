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
            <div class="main position-relative mb-0">
                <div class="d-flex">
                    <div class="w-100">
                        <button type="button" class="btn collapse-chat-sidebar" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-chat-sidebar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brackets-angle" width="20" height="20" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 4l-5 8l5 8" />
                            </svg>
                        </button>
                        <div class="chat-area">
                            <div class="chat-body">
                                <?php if (empty($chat_history)) { ?>
                                    <div class="chat-intro text-center" id="result-info">
                                        <?php if (!empty($analysisId)) { ?>
                                            <div class="my-5 px-lg-4">
                                                <h3 class="fw-bold mb-3">Data Analyst</h3>
                                                <div class="mb-5 fs-6">Upload your files and I can help analyze and visualize your data.</div>
                                                <div class="row g-3">
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Provide a concise summary of the document's content." data-submit="true" style="border-radius: 1rem;">
                                                            Summarize Document Content
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Analyze the contextual implications within the document." data-submit="true" style="border-radius: 1rem;">
                                                            Analyze Document Context
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Efficiently extract relevant information from the document." data-submit="true" style="border-radius: 1rem;">
                                                            Extract Document Information
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Identify and extract key insights from the document." data-submit="true" style="border-radius: 1rem;">
                                                            Extract Key Insights
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Annotate the document with notes and comments for deeper analysis." data-submit="true" style="border-radius: 1rem;">
                                                            Annotate Document Content
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Highlight the most important insights from the document." data-submit="true" style="border-radius: 1rem;">
                                                            Highlight Document Insights
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Summarize the key points and takeaways from the document." data-submit="true" style="border-radius: 1rem;">
                                                            Summarize Key Points
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Visualize and analyze data trends present in the document." data-submit="true" style="border-radius: 1rem;">
                                                            Visualize Data Trends
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Provide a detailed explanation of the document's contents." data-submit="true" style="border-radius: 1rem;">
                                                            Explain Document Details
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Evaluate the overall quality and accuracy of the document." data-submit="true" style="border-radius: 1rem;">
                                                            Evaluate Document Quality
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Translate the document into " data-submit="false" style="border-radius: 1rem;">
                                                            Translate Document Language
                                                        </button>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <button type="button" class="btn w-100 h-100 p-3 border hover-border" data-text="Rewrite the document to improve readability and coherence." data-submit="true" style="border-radius: 1rem;">
                                                            Rewrite Document Text
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="d-flex justify-content-center align-items-center border rounded" style="min-height: calc(100vh - 130px);">
                                                <div class="p-2 p-sm-5 text-center">
                                                    <h3 class="fw-bold mb-3">Data Analyst</h3>
                                                    <div class="mb-4 fs-6">Upload your file for data analysis, summarization, and more.</div>
                                                    <div class="mb-4">You can add multiple PDF, DOC, TXT, and other files together.</div>
                                                    <div class="mb-5">
                                                        <img src="<?php echo $this->url("assets/img/icon/pdf.svg"); ?>" alt="PDF" width="50">
                                                        <img src="<?php echo $this->url("assets/img/icon/doc.svg"); ?>" alt="DOC" width="50">
                                                        <img src="<?php echo $this->url("assets/img/icon/txt.svg"); ?>" alt="TXT" width="50">
                                                    </div>
                                                    <div id="uploadError" class="alert alert-danger py-2 mb-4" style="display: none;">Something went wrong. Please try again.</div>
                                                    <div id="UploadProgress" class="progress mb-4" style="display: none;">
                                                        <div id="progressBar" class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                    </div>
                                                    <?php if (!empty($plan['analyst'])) { ?>
                                                        <input type="file" id="fileInput" name="files" style="display: none" accept=".c,.cs,.cpp,.doc,.docx,.html,.htm,.java,.json,.md,.pdf,.php,.pptx,.py,.py,.rb,.tex,.txt,.css,.js,.sh,.ts" multiple>
                                                        <button type="button" id="uploadButton" class="btn btn-lg btn-primary px-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-upload">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                <path d="M7 9l5 -5l5 5" />
                                                                <path d="M12 4l0 12" />
                                                            </svg><span class="ms-2 fw-bold">Upload File</span>
                                                        </button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-lg btn-primary px-4" disabled>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-upload">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                <path d="M7 9l5 -5l5 5" />
                                                                <path d="M12 4l0 12" />
                                                            </svg><span class="ms-2 fw-bold">Upload File</span>
                                                        </button>
                                                        <div class="alert alert-warning text-center mt-4">To access this feature, please upgrade your current plan.</div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <div id="chat-message">
                                    <?php if (!empty($chat_history)) { ?>
                                        <?php foreach ($chat_history as $chat) { ?>
                                            <?php if ($chat['role'] == 'user') { ?>
                                                <div class="d-flex user-message">
                                                    <div class="flex-shrink-0 me-3">
                                                        <?php if (!empty($this->user['profile_image'])) { ?>
                                                            <div class="chat-user">
                                                                <img class="rounded-pill img-fluid" src="<?php echo $this->user['profile_image']; ?>" width="28" height="28">
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="chat-user bg-dark text-white notranslate"><?php echo mb_substr($this->user['name'], 0, 1); ?></div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="chat-content">
                                                        <h6 class="fw-bold">You</h6>
                                                        <div class="markdown ai-content notranslate"><?php echo htmlspecialchars($chat['content']); ?></div>
                                                        <div class="chat-action pt-1">
                                                            <div class="clipboard">
                                                                <button type="button" class="btn btn-sm border-0 px-0 btn-clipboard" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy to clipboard" data-copied-title="Copied!">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-clipboard" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                        <path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path>
                                                                        <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                                                                    </svg>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check2" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M5 12l5 5l10 -10" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="ms-3 d-none">
                                                                <button type="button" class="btn btn-sm border-0 px-0 btn-save-prompt" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regenerate">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="d-flex response-message">
                                                    <div class="flex-shrink-0 me-3">
                                                        <?php if (!empty($assistant['thumbnail'])) { ?>
                                                            <div class="chat-user">
                                                                <img class="rounded-pill img-fluid" src="<?php echo $assistant['thumbnail']; ?>" width="28" height="28">
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="chat-user bg-white text-dark notranslate"><?php echo !empty($assistant['name']) ? mb_substr($assistant['name'], 0, 1) : 'A'; ?></div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="chat-content">
                                                        <h6 class="fw-bold"><?php echo !empty($assistant['name']) ? $assistant['name'] : 'Analyst'; ?></h6>
                                                        <div class="markdown ai-content notranslate"><?php echo htmlspecialchars($chat['content']); ?></div>
                                                        <div class="chat-action pt-1">
                                                            <div class="clipboard">
                                                                <button type="button" class="btn btn-sm border-0 px-0 btn-clipboard" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Copy to clipboard" data-copied-title="Copied!">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-clipboard" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                        <path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path>
                                                                        <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                                                                    </svg>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check2" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M5 12l5 5l10 -10" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="ms-3 d-none">
                                                                <button type="button" class="btn btn-sm border-0 px-0 btn-save-prompt" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regenerate">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div id="response" style="display: none;">
                                    <div class="d-flex response-message">
                                        <div class="flex-shrink-0 me-3">
                                            <?php if (!empty($assistant['thumbnail'])) { ?>
                                                <div class="chat-user">
                                                    <img class="rounded-pill img-fluid" src="<?php echo $assistant['thumbnail']; ?>" width="28" height="28">
                                                </div>
                                            <?php } else { ?>
                                                <div class="chat-user bg-white text-dark notranslate"><?php echo !empty($assistant['name']) ? mb_substr($assistant['name'], 0, 1) : 'A'; ?></div>
                                            <?php } ?>
                                        </div>
                                        <div class="chat-content">
                                            <h6 class="fw-bold"><?php echo !empty($assistant['name']) ? $assistant['name'] : 'Analyst'; ?></h6>
                                            <div class="markdown ai-content notranslate"></div>
                                            <span class="result-processing">
                                                <svg width="24" height="24" class="me-2" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="10.5" class="background"></circle>
                                                    <circle cx="12" cy="12" r="10.5"></circle>
                                                </svg>Reading documents
                                            </span>
                                            <div class="chat-action pt-1" style="display: none;">
                                                <div class="clipboard">
                                                    <button type="button" class="btn btn-sm border-0 px-0 btn-clipboard" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Copy to clipboard" data-copied-title="Copied!">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-clipboard" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path>
                                                            <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check2" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M5 12l5 5l10 -10" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="ms-3 d-none">
                                                    <button type="button" class="btn btn-sm border-0 px-0 btn-regenerate" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regenerate">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="user-response" style="display: none;">
                                    <div class="d-flex user-message">
                                        <div class="flex-shrink-0 me-3">
                                            <?php if (!empty($this->user['profile_image'])) { ?>
                                                <div class="chat-user">
                                                    <img class="rounded-pill img-fluid" src="<?php echo $this->user['profile_image']; ?>" width="28" height="28">
                                                </div>
                                            <?php } else { ?>
                                                <div class="chat-user bg-dark text-white notranslate"><?php echo mb_substr($this->user['name'], 0, 1); ?></div>
                                            <?php } ?>
                                        </div>
                                        <div class="chat-content">
                                            <h6 class="fw-bold">You</h6>
                                            <div class="ai-content notranslate"></div>
                                            <div class="chat-action pt-1">
                                                <div class="clipboard">
                                                    <button type="button" class="btn btn-sm border-0 px-0 btn-clipboard" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Copy to clipboard" data-copied-title="Copied!">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-clipboard" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path>
                                                            <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-check2" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M5 12l5 5l10 -10" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="ms-3 d-none">
                                                    <button type="button" class="btn btn-sm border-0 px-0 btn-regenerate" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Regenerate">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($analysisId)) { ?>
                                <div class="chat-footer py-3">
                                    <div class="chat-scroll">
                                        <button type="button" class="btn btn-sm btn-light" id="scrollDownBtn" style="display: none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-down">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M18 13l-6 6" />
                                                <path d="M6 13l6 6" />
                                            </svg>
                                        </button>
                                    </div>
                                    <?php if (!empty($plan['analyst'])) { ?>
                                        <form id="analysis" method="post" data-id="<?php echo !empty($_GET['c']) && is_string($_GET['c']) ? $_GET['c'] : null; ?>" data-user="<?php echo mb_substr($this->user['name'], 0, 1); ?>">
                                            <div class="chatbox d-flex align-items-end position-relative input-group">
                                                <div>
                                                    <button type="button" id="uploadButton" class="btn border-0 me-0" aria-label="file" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Upload file">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path fill="currentColor" fill-rule="evenodd" d="M9 7a5 5 0 0 1 10 0v8a7 7 0 1 1-14 0V9a1 1 0 0 1 2 0v6a5 5 0 0 0 10 0V7a3 3 0 1 0-6 0v8a1 1 0 1 0 2 0V9a1 1 0 1 1 2 0v6a3 3 0 1 1-6 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="file" id="fileInput" name="files" style="display: none" accept=".c,.cs,.cpp,.doc,.docx,.html,.htm,.java,.json,.md,.pdf,.php,.pptx,.py,.py,.rb,.tex,.txt,.css,.js,.sh,.ts" multiple>
                                                </div>
                                                <textarea id="prompt-input" tabindex="0" data-id="" placeholder="Write message here" class="form-control autosize" autofocus></textarea>
                                                <div>
                                                    <button type="submit" id="btn-submit" class="btn border-0 btn-submit" aria-label="submit" disabled>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 5l0 14" />
                                                            <path d="M18 11l-6 -6" />
                                                            <path d="M6 11l6 -6" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } else { ?>
                                        <div class="alert alert-warning text-center">To access this feature, please upgrade your current plan.</div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="modal fade" id="no-credits-modal" tabindex="-1" aria-labelledby="nocredits" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-content">
                                        <div class="modal-body text-center py-4">
                                            <div class="mb-4 mx-auto text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="fw-bold mb-3">Insufficient Credits</h3>
                                            <p class="text-muted fw-semibold fs-6 mb-4">Sorry, you have exhausted your credits to generate more content. Please upgrade your account.</p>
                                            <button type="button" class="btn btn-lg btn-primary fw-bold px-4 me-3" data-bs-dismiss="modal" aria-label="Close">Got it</button><a class="btn btn-success fw-semibold" href="<?php echo $this->url('my/plans'); ?>">Upgrade</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="result-error-modal" tabindex="-1" aria-labelledby="resulterror" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-content">
                                        <div class="modal-body text-center py-4">
                                            <div class="mb-4 mx-auto text-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="fw-bold mb-3">Generation Failed</h3>
                                            <p class="text-muted fw-semibold fs-6 mb-4 error-message">Something went wrong, please try again.</p>
                                            <button type="button" class="btn btn-lg btn-primary fw-bold px-4" data-bs-dismiss="modal" aria-label="Close">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="input-required-modal" tabindex="-1" aria-labelledby="addmoretext" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-content">
                                        <div class="modal-body text-center py-4">
                                            <div class="mb-4 mx-auto text-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="fw-bold mb-3">Add more text</h3>
                                            <p class="text-muted fw-semibold fs-6 mb-4">Your request is too short, please add more details.</p>
                                            <button type="button" class="btn btn-lg btn-primary fw-bold px-4" data-bs-dismiss="modal" aria-label="Close">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="offcanvas chat-sidebar" id="offcanvas-chat-sidebar">
                        <div class="offcanvas-header">
                            <div></div>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="mx-3 mx-xxl-0">
                            <?php if (!empty($analysisId)) { ?>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col">
                                            <a class="btn btn-light fw-semibold w-100" href="<?php echo $this->url('my/analyst?new'); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 5l0 14" />
                                                    <path d="M5 12l14 0" />
                                                </svg><span class="ms-1">New Chat</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="chat-history">
                                <div class="chat-history-body" data-simplebar>
                                    <?php if (!empty($analysisId)) { ?>
                                        <div class="mb-4" id="fileHistory" style="display: <?php echo empty($file_history) ? 'none' : 'block'; ?>;">
                                            <div id="uploadError" class="alert alert-danger py-2 mb-4" style="display: none;">Something went wrong. Please try again.</div>
                                            <div id="UploadProgress" class="progress mb-2" style="display: none;">
                                                <div id="progressBar" class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            </div>
                                            <div class="row gy-2" id="fileList">
                                                <div class="col-12 col-md-6 col-xxl-4 w-100" id="fileItem" style="display: none;">
                                                    <div class="card p-2 border shadow-none bg-transparent" style="border-radius: 12px">
                                                        <div class="d-flex">
                                                            <div>
                                                                <div class="rounded text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; background-color: #fc5d92;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
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
                                                                    <div class="fw-semibold text-truncate mb-1 fileName"></div>
                                                                    <div class="text-muted small text-uppercase fileExtension"></div>
                                                                </div>
                                                                <div class="pt-1 ms-2 delete-button" style="display: none;">
                                                                    <button type="button" class="dropdown-item m-0 d-flex align-items-center fileId delete_file" data-id="" data-bs-toggle="modal" data-bs-target="#deleteFile">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                                <?php foreach (!empty($file_history) ? $file_history : [] as $val) {
                                                    $extension = pathinfo($val['name'], PATHINFO_EXTENSION); ?>
                                                    <div class="col-12 col-md-6 col-xxl-4 w-100" id="<?php echo $val['id']; ?>">
                                                        <div class="card p-2 border shadow-none bg-transparent" style="border-radius: 12px">
                                                            <div class="d-flex">
                                                                <div>
                                                                    <div class="rounded text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; background-color: #fc5d92;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
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
                                                                        <div class="fw-semibold text-truncate fileName notranslate"><?php echo htmlspecialchars($val['name']); ?></div>
                                                                        <div class="text-muted small text-uppercase fileExtension notranslate"><?php echo !empty($extension) ? $extension : null; ?></div>
                                                                    </div>
                                                                    <div class="pt-1 ms-2 delete-button" style="display: none;">
                                                                        <button type="button" class="dropdown-item m-0 d-flex align-items-center delete_file" data-id="<?php echo $val['id']; ?>" data-bs-toggle="modal" data-bs-target="#deleteFile">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($chats)) { ?>
                                        <div class="fw-semibold text-muted px-3 py-2">History</div>
                                        <ul class="nav d-block">
                                            <?php foreach ($chats as $val) { ?>
                                                <li class="nav-item position-relative chat-history-item">
                                                    <a class="nav-link d-flex <?php echo $val['id'] == $analysisId ? 'active' : null; ?>" href="<?php echo $this->url("my/analyst/$val[id]"); ?>">
                                                        <span class="text-truncate">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" width="16" height="16" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1"></path>
                                                            </svg><span class="ms-2 notranslate" id="name_<?php echo $val['id']; ?>"><?php echo $val['title'] ? htmlspecialchars($val['title']) : 'Untitle'; ?></span>
                                                        </span>
                                                    </a>
                                                    <?php if (!empty($analysisId)) { ?>
                                                        <div class="position-absolute end-0 top-0 m-1 dropdown chat-history-action" style="display: none;">
                                                            <button class="btn btn-sm border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dots">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                                    <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                                </svg>
                                                            </button>
                                                            <ul class="dropdown-menu shadow p-2" style="min-width: 130px;">
                                                                <li>
                                                                    <button type="button" class="dropdown-item m-0 d-flex align-items-center rename_chat" data-id="<?php echo $val['id']; ?>" data-bs-toggle="modal" data-bs-target="#rename">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                                            <path d="M13.5 6.5l4 4" />
                                                                        </svg><span class="ms-2">Rename</span>
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button type="button" class="dropdown-item m-0 d-flex align-items-center text-danger delete_chat" data-id="<?php echo $val['id']; ?>" data-bs-toggle="modal" data-bs-target="#delete">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M4 7l16 0" />
                                                                            <path d="M10 11l0 6" />
                                                                            <path d="M14 11l0 6" />
                                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                        </svg><span class="ms-2">Delete</span>
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade modal-sm" id="rename" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered z-3">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Rename chat</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="form" novalidate>
                                        <div class="mb-4">
                                            <label class="form-label text-muted">Chat title</label>
                                            <input type="text" name="name" class="form-control" minlength="3" maxlength="200" placeholder="e.g. New chat" required>
                                        </div>
                                        <div class="py-2">
                                            <button type="submit" class="btn btn-primary w-100" id="rename_chat" data-bs-dismiss="modal" data-loader="Saving...">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="delete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm z-3">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Delete chat</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="form" novalidate>
                                        <h6 class="mt-3 mb-4 text-center">Are you sure you want to permanently delete this chat?</h6>
                                        <div class="py-2">
                                            <input type="hidden" name="delete_id" value="">
                                            <button type="submit" class="btn btn-danger w-100" id="rename_chat" data-loader="Deleting...">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteFile" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm z-3">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Delete file</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="form" novalidate>
                                        <h6 class="mt-3 mb-4 text-center">Are you sure you want to delete this file?</h6>
                                        <div class="py-2">
                                            <input type="hidden" name="delete_file_id" value="">
                                            <button type="submit" class="btn btn-danger w-100" id="delete_chat" data-loader="Deleting...">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once APP . '/View/User/Tail.php'; ?>
    <script>
        $(document).ready(function() {
            const simpleBar = new SimpleBar(document.querySelector('.chat-body'));
            <?php if (!empty($analysisId)) { ?>
                simpleBar.getScrollElement().scrollTop = simpleBar.getContentElement().scrollHeight;
            <?php } ?>
        });
        const clipboard = new ClipboardJS(".btn-clipboard", {
            target: e => e.closest(".d-flex").querySelector(".ai-content"),
            text: e => e.closest(".d-flex").querySelector(".ai-content")
        });
        clipboard.on('success', function(e) {
            var btn = $(e.trigger);
            var tooltip = bootstrap.Tooltip.getInstance(e.trigger);
            tooltip.setContent({
                '.tooltip-inner': btn.attr('data-copied-title')
            });
            document.getSelection().removeAllRanges();
            btn.find('.bi-clipboard').hide();
            btn.find('.bi-check2').show();
            setTimeout(function() {
                btn.find('.bi-check2').hide();
                btn.find('.bi-clipboard').show();
                tooltip.hide();
                tooltip.setContent({
                    '.tooltip-inner': btn.attr('data-bs-title')
                });
            }, 2000);
        });
        clipboard.on('error', function(e) {
            var btn = $(e.trigger);
            const tooltip = bootstrap.Tooltip.getInstance(e.trigger);
            tooltip.setContent({
                '.tooltip-inner': 'Not copied!'
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const textarea = document.getElementById("prompt-input");
            const submitButton = document.getElementById("btn-submit");
            if (textarea) {
                textarea.addEventListener("input", function() {
                    if (textarea.value.trim().length > 0) {
                        submitButton.disabled = false;
                    } else {
                        submitButton.disabled = true;
                    }
                });
            }
        });
        document.querySelectorAll('.chat-history-action').forEach(button => {
            button.addEventListener('click', function(event) {
                if (this.style.display === 'block') {
                    this.style.display = 'none';
                } else {
                    this.style.display = 'block';
                }
                event.stopPropagation();
            });
        });
        document.addEventListener('click', () => {
            document.querySelectorAll('.chat-history-action').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        });
        $(document).ready(function() {
            $('[data-text]').click(function() {
                var dataText = $(this).attr('data-text');
                var dataSubmit = $(this).attr('data-submit');
                $('#prompt-input').val(dataText);
                $('#prompt-input').focus();
                $('#btn-submit').prop('disabled', false);
                if (dataSubmit === 'true') {
                    $('#analysis').submit();
                }
            });
        });
    </script>
</body>

</html>