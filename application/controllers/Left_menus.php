<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Types:
 * "" - Users default
 * "user" - Users custom & Clients custom
 * "client_default" - Clients default
 */

class Left_menus extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("left_menu");
    }

    private function check_left_menu_permission($type = "") {
        if ($type == "user") {
            if ($this->login_user->user_type == "staff") {
                $this->access_only_team_members();
            } else if ($this->login_user->user_type == "client") {
                $this->access_only_clients();
            }else if ($this->login_user->user_type == "vendor") {
                $this->access_only_vendors();
            }
        } else if (!$type || $type == "client_default" || $type == "vendor_default") {
            $this->access_only_admin();
        }
    }

    function index($type = "") {
        $this->check_left_menu_permission($type);

        $view_data["available_items"] = $this->left_menu->get_available_items($type);
        $view_data["sortable_items"] = $this->left_menu->get_sortable_items($type);
        //$view_data["preview"] = $this->left_menu->rander_left_menu(true, $type);
        $view_data["preview"] = $this->left_menu->rander_left_menu_preview(true, $type);

        if ($type == "user") {
            $this->load->view("left_menu/user_left_menu", $view_data);
        } else {
            $view_data["setting_active_tab"] = ($type == "client_default") ? "client_left_menu" : "left_menu";
            if($type == "vendor_default"){
                $view_data["setting_active_tab"] = ($type == "vendor_default") ? "vendor_left_menu" : "left_menu";
            }
            $view_data["type"] = $type;

            $this->template->rander("left_menu/index", $view_data);
        }
    }

    function save() {
        if (get_setting("disable_editing_left_menu_by_clients") && $this->login_user->user_type == "client") {
            redirect("forbidden");
        }

        if (get_setting("disable_editing_left_menu_by_vendorss") && $this->login_user->user_type == "vendor") {
            redirect("forbidden");
        }

        $type = $this->input->post("type");
        $this->check_left_menu_permission($type);

        $items_data = $this->input->post("data");
        if ($items_data) {
            $items_data = json_decode($items_data, true);

            //check if the setting menu has been added, if not, add it to the bottom
            if ($this->login_user->is_admin && $type != "client_default" && $type != "vendor_default"&& array_search("settings", array_column($items_data, "name")) === false) {
                $items_data[] = array("name" => "settings");
            }

            $items_data = serialize($items_data);
        }

        if ($type == "user") {
            $this->Settings_model->save_setting("user_" . $this->login_user->id . "_left_menu", $items_data);
            echo json_encode(array("success" => true, 'redirect_to' => get_uri($this->_prepare_user_custom_redirect_to_url()), 'message' => lang('settings_updated')));
        } else {
            if ($type == "client_default") {
                $this->Settings_model->save_setting("default_client_left_menu", $items_data);
            }else if ($type == "vendor_default") {
                $this->Settings_model->save_setting("default_vendor_left_menu", $items_data);
            } else {
                $this->Settings_model->save_setting("default_left_menu", $items_data);
            }

            echo json_encode(array("success" => true, 'message' => lang('settings_updated')));
        }
    }

    private function _prepare_user_custom_redirect_to_url() {
        $redirect_to = "team_members/view/" . $this->login_user->id . "/left_menu";
        if ($this->login_user->user_type == "client") {
            $redirect_to = "clients/contact_profile/" . $this->login_user->id . "/left_menu";
        }else if ($this->login_user->user_type == "resource") {
            $redirect_to = "rm_members/view/" . $this->login_user->id . "/left_menu";
        }else if ($this->login_user->user_type == "vendor") {
            $redirect_to = "vendors/contact_profile/" . $this->login_user->id . "/left_menu";
        }
        

        return $redirect_to;
    }

    function add_menu_item_modal_form() {
        $model_info = new stdClass();
        $model_info->title = $this->input->post("title");
        $model_info->url = $this->input->post("url");
        $model_info->is_sub_menu = $this->input->post("is_sub_menu");
        $model_info->open_in_new_tab = $this->input->post("open_in_new_tab");
        $model_info->icon = $this->input->post("icon");

        $view_data["model_info"] = $model_info;

        $this->load->view("left_menu/add_menu_item_modal_form", $view_data);
    }

    function prepare_custom_menu_item_data() {
        $title = $this->input->post("title");
        $url = $this->input->post("url");
        $is_sub_menu = $this->input->post("is_sub_menu");
        $open_in_new_tab = $this->input->post("open_in_new_tab");
        $icon = $this->input->post("icon");

        $item_array = array("name" => $title, "url" => $url, "is_sub_menu" => $is_sub_menu, "icon" => $icon, "open_in_new_tab" => $open_in_new_tab);
        $item_data = $this->left_menu->_get_item_data($item_array);

        if ($item_data) {
            echo json_encode(array("success" => true, "item_data" => $item_data));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    function restore($type = "") {
        $this->check_left_menu_permission($type);

        if ($type == "user") {
            $this->Settings_model->save_setting("user_" . $this->login_user->id . "_left_menu", "");
            redirect($this->_prepare_user_custom_redirect_to_url());
        } else {
            if ($type == "client_default") {
                $this->Settings_model->save_setting("default_client_left_menu", "");
                redirect("left_menus/index/client_default");
            }else if ($type == "vendor_default") {
                $this->Settings_model->save_setting("default_vendor_left_menu", "");
                redirect("left_menus/index/vendor_default");
            } else {
                $this->Settings_model->save_setting("default_left_menu", "");
                redirect("left_menus");
            }
        }
    }

}

/* End of file Left_menu.php */
/* Location: ./application/controllers/Left_menu.php */