<?php

namespace Controller;

class Offline extends Controller
{
    public function offline()
    {
        $setting = $this->settings('maintenance_message');
        $message = !empty($setting['maintenance_message']) ? $setting['maintenance_message'] : null;
        $this->title('Offline');
        die(require_once APP . '/View/Web/Offline.php');
    }
}
