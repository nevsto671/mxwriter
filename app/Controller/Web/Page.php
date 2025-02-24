<?php

namespace Controller\Web;

use Controller\WebController;

class Page extends WebController
{
    public function index($slug)
    {
        $page = $this->page(trim($slug, '/'));
        if (empty($page)) die(require_once APP . '/View/Error.php');
        $this->title(!empty($page['title']) ? $page['title'] : $page['name']);
        require_once APP . '/View/Web/Page.php';
    }
}
