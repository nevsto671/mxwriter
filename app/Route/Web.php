<?php

Route::get('/', ['Controller\Web\Home', 'index']);
Route::get('/blog', ['Controller\Web\Blog', 'index']);
Route::get('/blog/{any}', ['Controller\Web\Blog', 'index']);

Route::get('/payment', ['Controller\Web\Payment', 'index']);
Route::post('/payment/success', ['Controller\Web\Payment', 'success']);
Route::post('/payment/cancel', ['Controller\Web\Payment', 'cancel']);
Route::post('/payment/transaction/{slug}', ['Controller\Web\Payment', 'transaction']);
Route::post('/payment/webhook/{slug}', ['Controller\Web\Payment', 'webhook']);

Route::get('/my', ['Controller\User\Dashboard', 'index']);
Route::get('/my/templates', ['Controller\User\Templates', 'index']);
Route::post('/my/templates/{any}', ['Controller\User\Templates', 'index']);
Route::post('/my/editor', ['Controller\User\Editor', 'index']);
Route::post('/my/article-generator', ['Controller\User\ArticleGenerator', 'index']);
Route::post('/my/content-rewriter', ['Controller\User\ContentRewriter', 'index']);
Route::post('/my/chat', ['Controller\User\Chat', 'index']);
Route::post('/my/image-generator', ['Controller\User\ImageGenerator', 'index']);
Route::post('/my/analyst', ['Controller\User\Analyst', 'index']);
Route::post('/my/analyst/{any}', ['Controller\User\Analyst', 'index']);
Route::get('/my/history', ['Controller\User\History', 'index']);
Route::get('/my/documents', ['Controller\User\Documents', 'index']);
Route::post('/my/usage', ['Controller\User\Usage', 'index']);
Route::post('/my/plans', ['Controller\User\Plans', 'index']);
Route::post('/my/account', ['Controller\User\Account', 'index']);

Route::post('/my/billing', ['Controller\User\Billing', 'index']);
Route::post('/my/billing/payments', ['Controller\User\Payments', 'index']);
Route::post('/my/billing/subscriptions', ['Controller\User\Subscriptions', 'index']);
Route::get('/my/billing/transactions', ['Controller\User\Transactions', 'index']);

Route::get('/admin', ['Controller\Admin\Dashboard', 'index']);
Route::post('/admin/subscriptions', ['Controller\Admin\Subscriptions', 'index']);
Route::post('/admin/transactions', ['Controller\Admin\Transactions', 'index']);
Route::post('/admin/plans', ['Controller\Admin\Plans', 'index']);
Route::post('/admin/users', ['Controller\Admin\Users', 'index']);
Route::post('/admin/blogs', ['Controller\Admin\Blogs', 'index']);
Route::post('/admin/pages', ['Controller\Admin\Pages', 'index']);
Route::post('/admin/templates', ['Controller\Admin\Templates', 'index']);
Route::post('/admin/assistants', ['Controller\Admin\Assistants', 'index']);
Route::post('/admin/settings', ['Controller\Admin\Settings', 'index']);

Route::post('/login', ['Controller\Login', 'index']);
Route::get('/login/{name}', ['Controller\Login', 'social']);
Route::post('/signup', ['Controller\Signup', 'index']);
Route::post('/reset', ['Controller\Reset', 'index']);
Route::get('/logout', ['Controller\Controller', 'logout']);
Route::post('/data/{any}', ['Controller\Data', 'func']);

Route::get('/{any}', ['Controller\Web\Page', 'index']);
Route::get('/{*}', ['Controller\Controller', 'error']);
