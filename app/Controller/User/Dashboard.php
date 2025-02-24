<?php

namespace Controller\User;

use DB;
use Controller\UserController;

class Dashboard extends UserController
{
    public function index()
    {
        $user = $this->userDetails(['id' => $this->uid], 'words_generated, images_generated, words, images');
        $time_saved = round(($user['words_generated'] / 8.3) / 60);
        $recent_history = DB::query("SELECT templates.* FROM templates JOIN recent_history ON templates.id = recent_history.template_id WHERE recent_history.type='template' AND recent_history.user_id=$this->uid AND templates.status=1 ORDER BY created DESC LIMIT 4");
        $popular_history = DB::query("SELECT templates.* FROM templates JOIN (SELECT template_id, COUNT(template_id) AS template_count FROM (SELECT template_id FROM recent_history WHERE type = 'template' ORDER BY created DESC LIMIT 200) AS recent_subquery GROUP BY template_id ORDER BY template_count DESC LIMIT 4) AS top_templates ON templates.id = top_templates.template_id WHERE templates.status = 1 AND (templates.user_id=0 OR templates.user_id=$this->uid);");
        $random_history = DB::select('templates', 'id, title, slug, description, color, premium, icon', ['status' => 1, 'user_id' => 0], "ORDER BY RAND() LIMIT 8");
        if ((time() - strtotime($this->setting['last_updated'])) > 360) $this->refresh();
        $this->title('Dashboard');
        require_once APP . '/View/User/Dashboard.php';
    }

    public function first_name()
    {
        $name = trim($this->user['name']);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));
        return $first_name;
    }
}
