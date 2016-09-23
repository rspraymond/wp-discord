<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class AdminFormFieldBuilder
{

    public $name, $type = 'text', $value = null, $attr = [], $placeholder = null;

    /**
     * AdminFormFieldBuilder constructor.
     * @param array $params['name', 'type', 'value', 'attr']
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

    public function number_field_render()
    {
        return $this->text_field_render('number');
    }

    public function radio_field_render()
    {
        //@TODO radio_field_render
    }

    public function select_field_render()
    {
        //@TODO select_field_render
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

    public static function render_field($params) {
        $field = new self($params);

        $field->render();
    }


}