<?php

namespace Controller\Web;

use DB;
use Pagination;
use Controller\WebController;

class Blog extends WebController
{
    public function index($slug = null)
    {
        if (empty($this->setting['blog_status'])) $this->redirect(null);

        if ($slug) {
            $blogId = array_slice(explode('-', $slug), -1)[0];
            if ($this->rid == 1 && isset($_GET['preview'])) {
                $results = DB::select('blogs', '*', ['id' => base64_decode($blogId)], 'LIMIT 1');
            } else {
                $results = DB::select('blogs', '*', ['id' => base64_decode($blogId), 'status' => 1], 'LIMIT 1');
            }
            $blog = isset($results[0]) ? $results[0] : null;
            $this->setting['og_description'] = $this->setting['site_description'];
            if (!empty($blog['slug'])) $this->setting['og_url'] = $this->url("blog/$blog[slug]-" . base64_encode($blog['id']));
            if (!empty($blog['thumbnail'])) $this->setting['og_image'] = $this->url($blog['thumbnail']);
            $this->title(isset($blog['title']) ? $blog['title'] : 'Not found');
        } else {
            $limit = 25;
            $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page * $limit) - $limit;
            $results = DB::select('blogs', '*', ['status' => 1], 'ORDER BY id DESC LIMIT ' . $offset . ',' . $limit);
            $pager = new Pagination($page, $limit);
            $total = DB::count('blogs', ['status' => 1]);
            $pager->total($total);
            $pagination = $pager->execute(true);
            $this->title('Blog');
        }

        require_once APP . '/View/Web/Blogs.php';
    }
}
