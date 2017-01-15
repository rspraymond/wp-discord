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
    public $attr = [];
    public $placeholder = null;

    /**
     * AdminFormFieldBuilder constructor.
     * @param array $params ['name', 'type', 'value', 'attr']
     */
    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    public function render()
    {
        $field_function = $this->type . '_field_render';

        $output = $this->$field_function();

        echo $output;
    }

    public function email_field_render()
    {
        return $this->text_field_render('email');
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
        $output = '<label for="' . $name . '">' . $label . '</label>' . PHP_EOL;

        echo $output;
    }

    public function number_field_render()
    {
        return $this->text_field_render('number');
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
    public static function select($name, array $options, $selected = null, $attr = [])
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

    public function text_field_render($type = 'text')
    {
        $text_field = '<input type="' . $type . '" value="' . $this->value . '" name="' . $this->name . '"';

        if (!empty($this->attr)) {
            foreach ($this->attr as $key => $value) {
                $text_field .= ' ' . $key . '="' . $value . '"';
            }
        }

        $text_field .= '>'; // End of tag

        return $text_field;
    }

    public function textarea_field_render()
    {
        //@TODO textarea_field_render
    }

    public static function render_field($params)
    {
        $field = new self($params);

        $field->render();
    }
}
