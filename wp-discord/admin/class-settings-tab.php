<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

include_once(plugin_dir_path(__FILE__) . 'class-admin-form-field-builder.php');

class SettingsTab
{
    public $partial, $name, $fields = [], $params = [];

    public function __construct($name, $partial = null, $params = [])
    {
        $this->name = $name;

        if (empty($partial)) {
            $this->partial = $this->get_partial_path();
        } else {
            $this->partial = $partial;
        }

        $this->params = $params;

        if (isset($this->params['fields'])) {
            $this->fields = $this->params['fields'];
        }

        $this->set_fields();
    }

    public function display()
    {
        $this->set_params();

        echo '<div class="postbox"><div class="inside">';
        include $this->partial;
        echo '</div></div>';
    }

    public function get_display_name()
    {
        return ucwords(str_replace(['_', '-'], ' ', $this->name));
    }

    public function get_partial_path()
    {
        return plugin_dir_path(__FILE__) . 'partials/' . $this->name . '_tab.php';
    }

    public function set_fields()
    {
        //check fields settings
        $fields_function_name = $this->name . '_fields';

        if (method_exists($this, $fields_function_name)) {
            $this->fields = $this->$fields_function_name();
        }

        foreach ($this->fields as $key => $params) {
            $this->fields[$key] = new AdminFormFieldBuilder($params);
        }
    }

    public function set_params()
    {
        foreach ($this->params as $key => $param) {
            $$key = $param;
        }
    }
}