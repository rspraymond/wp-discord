<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class AdminFormFieldBuilder
{
    public $name;
    public $type = 'text';
    public $value = null;
    public $attr = array();
    public $placeholder = null;

    /**
     * Build an input html element with email type.
     * @param string $name
     * @param string $value
     * @param array $attr
     *
     * @since    0.3.0
     */
    public function email($name, $value = null, $attr = array())
    {
        self::text_field_render('email', $name, $value, $attr);
    }

    public function checkbox_field_render()
    {
        //@TODO checkbox_field_render
    }

    /**
     * Build a standard label html element.
     * @param string $name Field name for label.
     * @param string $label Label Text
     *
     * @since    0.3.0
     */
    public static function label($name, $label)
    {
        $output = '<label class="' . WPD_PREFIX . $name . '" for="' . $name . '">' . $label . '</label>' . PHP_EOL;

        echo $output;
    }

    /**
     * Build an input html element with number type.
     * @param string $name
     * @param string $value
     * @param array $attr
     *
     * @since    0.3.0
     */
    public static function number($name, $value, $attr = array())
    {
        self::input('number', $name, $value, $attr);
    }

    public function radio_field_render()
    {
        //@TODO radio_field_render
    }

    /**
     * Build a standard select html element.
     * @param string $name
     * @param array $options
     * @param mixed $selected
     * @param array $attr
     *
     * @since    0.3.0
     */
    public static function select($name, array $options, $selected = null, $attr = array())
    {
        $output = '<select name="' . $name;

        foreach ($attr as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }

        $output .= '">' . PHP_EOL;

        foreach ($options as $value => $text) {
            $option = '<option value="' . $value . '">' . $text . '</option>' . PHP_EOL;

            if ($selected == $value) {
                $option = str_replace('<option', '<option selected', $option);
            }

            $output .= $option;
        }

        $output .= '</select>' . PHP_EOL;
        ;

        echo $output;
    }

    /**
     * Builds out input field
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array $attr
     *
     *
     * @since    0.3.0
     */
    public static function input($type = 'text', $name, $value = null, $attr = array())
    {
        $output = '<input class="wpd_field ' . WPD_PREFIX . $name . '" type="' . $type . '" value="' . $value . '" name="' . $name . '"';

        if (!empty($attr)) {
            foreach ($attr as $key => $attr_value) {
                $output .= ' ' . $key . '="' . $attr_value . '"';
            }
        }

        $output .= '>'; // End of tag

        echo $output;
    }

    /**
     * Build an input html element with text type.
     * @param string $name
     * @param string $value
     * @param array $attr
     *
     * @since    0.3.0
     */
    public static function text($name, $value = null, $attr = array())
    {
        self::input('text', $name, $value, $attr);
    }


    public function textarea_field_render()
    {
        //@TODO textarea_field_render
    }
}
