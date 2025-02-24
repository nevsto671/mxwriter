<?php

namespace Controller\Admin;

use DB;
use Controller\AdminController;

class Plans extends AdminController
{
    public function index()
    {
        if (isset($_GET['add'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name'])) {
                $data['duration'] = !empty($_POST['duration']) ? $_POST['duration'] : null;
                $data['name'] = isset($_POST['name']) ? $_POST['name'] :  'Unknown';
                $data['title'] = isset($_POST['title']) ? $_POST['title'] : null;
                $data['price'] = isset($_POST['price']) && is_numeric($_POST['price']) ? $_POST['price'] : 0;
                $data['words'] = isset($_POST['words']) && is_numeric($_POST['words']) ? $_POST['words'] : null;
                $data['images'] = isset($_POST['images']) && is_numeric($_POST['images']) ? $_POST['images'] : null;
                $data['documents'] = isset($_POST['documents']) && is_numeric($_POST['documents']) ? $_POST['documents'] : null;
                $data['total_brands'] = isset($_POST['total_brands']) && is_numeric($_POST['total_brands']) ? $_POST['total_brands'] : null;
                $data['total_templates'] = isset($_POST['total_templates']) && is_numeric($_POST['total_templates']) ? $_POST['total_templates'] : null;
                $data['total_assistants'] = isset($_POST['total_assistants']) && is_numeric($_POST['total_assistants']) ? $_POST['total_assistants'] : null;
                $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
                $data['premium'] =  isset($_POST['premium']) ? 1 : 0;
                $data['assistant'] =  isset($_POST['assistant']) ? 1 : 0;
                $data['analyst'] =  isset($_POST['analyst']) ? 1 : 0;
                $data['brand'] =  isset($_POST['brand']) ? 1 : 0;
                $data['highlight'] =  isset($_POST['highlight']) ? 1 : 0;
                $data['my_template'] =  isset($_POST['my_template']) ? 1 : 0;
                $data['my_assistant'] =  isset($_POST['my_assistant']) ? 1 : 0;
                $data['own_api'] =  isset($_POST['own_api']) ? 1 : 0;
                $data['status'] =  isset($_POST['status']) ? 1 : 0;
                if (!$data['duration'] && !$data['words']) $this->redirect("admin/plans", "This plan is not available for unlimited word generate.", "error");
                $id = DB::insert('plans', $data);
                if ($data['price'] == 0) DB::update('settings', ['description' => $id], ['name' => 'free_plan']);
                $this->redirect("admin/plans", "Plan has been added successfully.");
            }
        } else if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $plan_result = DB::select('plans', '*', ['id' => $_GET['edit']], 'LIMIT 1');
            $plan = isset($plan_result[0]) ? $plan_result[0] : null;
            if (!$plan) $this->redirect("admin/plans");

            if (!empty($_GET['duplicate']) && $_GET['duplicate'] == md5($plan['id'])) {
                if (!empty($plan)) {
                    unset($plan['id']);
                    unset($plan['status']);
                    $id = DB::insert('plans', $plan);
                    if ($id) $this->redirect("admin/plans?edit=$id", "A new plan has been successfully created. You can now modify it to meet your needs.");
                }
                $this->redirect("admin/plans", "The system failed to create a duplicate plan.", "error");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name'])) {
                $data['duration'] = !empty($_POST['duration']) ? $_POST['duration'] : null;
                $data['name'] = isset($_POST['name']) ? $_POST['name'] :  'Unknown';
                $data['title'] = isset($_POST['title']) ? $_POST['title'] : null;
                $data['price'] = isset($_POST['price']) && is_numeric($_POST['price']) ? $_POST['price'] : 0;
                $data['words'] = isset($_POST['words']) && is_numeric($_POST['words']) ? $_POST['words'] : null;
                $data['images'] = isset($_POST['images']) && is_numeric($_POST['images']) ? $_POST['images'] : null;
                $data['documents'] = isset($_POST['documents']) && is_numeric($_POST['documents']) ? $_POST['documents'] : null;
                $data['total_brands'] = isset($_POST['total_brands']) && is_numeric($_POST['total_brands']) ? $_POST['total_brands'] : null;
                $data['total_templates'] = isset($_POST['total_templates']) && is_numeric($_POST['total_templates']) ? $_POST['total_templates'] : null;
                $data['total_assistants'] = isset($_POST['total_assistants']) && is_numeric($_POST['total_assistants']) ? $_POST['total_assistants'] : null;
                $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
                $data['premium'] =  isset($_POST['premium']) ? 1 : 0;
                $data['assistant'] =  isset($_POST['assistant']) ? 1 : 0;
                $data['analyst'] =  isset($_POST['analyst']) ? 1 : 0;
                $data['brand'] =  isset($_POST['brand']) ? 1 : 0;
                $data['highlight'] =  isset($_POST['highlight']) ? 1 : 0;
                $data['my_template'] =  isset($_POST['my_template']) ? 1 : 0;
                $data['my_assistant'] =  isset($_POST['my_assistant']) ? 1 : 0;
                $data['own_api'] =  isset($_POST['own_api']) ? 1 : 0;
                $data['status'] =  isset($_POST['status']) ? 1 : 0;
                if (!$data['duration'] && !$data['words']) $this->redirect("admin/plans", "This plan is not available for unlimited word generate.", "error");
                DB::update('plans', $data, ['id' => $plan['id']]);
                if ($data['price'] == 0) DB::update('settings', ['description' => $plan['id']], ['name' => 'free_plan']);
                $this->redirect("admin/plans", "Plan has been updated successfully.");
            }
        } else if (!empty($_GET['delete']) && is_numeric($_GET['delete']) && isset($_GET['sign']) && $_GET['sign'] == md5($_GET['delete'])) {
            DB::delete('plans', ['id' => $_GET['delete']]);
            $this->redirect("admin/plans", "Plan has been deleted successfully.");
        } else {
            $monthly_plans = DB::select('plans', '*', ['duration' => 'month'], 'ORDER BY price');
            $yearly_plans = DB::select('plans', '*', ['duration' => 'year'], 'ORDER BY price');
            $lifetime_plans = DB::select('plans', '*', ['duration' => 'lifetime'], 'ORDER BY price');
            $prepaid_plans = DB::select('plans', '*', ['duration' => 'prepaid'], 'ORDER BY images, price');
        }
        $setting = $this->settings(['free_plan']);
        $this->title('Plans');
        require_once APP . '/View/Admin/Plans.php';
    }
}
