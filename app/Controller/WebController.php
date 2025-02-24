<?php

namespace Controller;

class WebController extends Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->rid != 1 && $this->setting['maintenance_status']) $this->maintenance();
    }
}
