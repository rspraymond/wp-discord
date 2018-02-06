<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

include_once(plugin_dir_path(__FILE__) . 'class-admin-form-field-builder.php');

class SettingsTab
{
    public $partial;
    public $name;
    public $fields = array();
    public $params = array();

    public function __construct($name, $attr = array(), $partial = null)
    {
        $this->name = $name;

        if (empty($partial)) {
            $this->partial = $this->get_partial_path();
        } else {
            $this->partial = $partial;
        }

        foreach ($attr as $key => $value) {
            $this->{$key} = $value;
        }

        $this->set_fields();
    }

    public function display()
    {
        foreach (get_object_vars($this) as $key => $value) {
            ${$key} = $value;
        }

        echo '<div class="postbox"><div class="inside">';
        include $this->partial;
        echo '</div></div>';
    }

    public function get_display_name()
    {
        return ucwords(str_replace(array('_', '-'), ' ', $this->name));
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
}
