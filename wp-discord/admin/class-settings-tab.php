<?php

class SettingsTab
{
    public $partial, $name, $params = [];

    public function __construct($name, $partial = null, $params = [])
    {
        $this->name = $name;

        if (empty($partial)) {
            $this->partial =  $this->get_partial_path();
        } else {
            $this->partial = $partial;
        }

        $this->params = $params;
    }

    public function display()
    {
        $this->set_params();

        include $this->partial;
    }

    public function get_display_name()
    {
        return ucwords(str_replace(['_', '-'], ' ', $this->name));
    }

    public function get_partial_path()
    {
        return plugin_dir_path(__FILE__) . 'partials/' . $this->name . '_tab.php';
    }

    public function set_params()
    {
        foreach($this->params as $key => $param) {
            $$key = $param;
        }
    }
}