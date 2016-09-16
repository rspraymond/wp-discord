<?php

class AdminPageBuilder
{
    /**
     * Path to html file
     * @var $file_path
     */
    protected $file_path;

    public function __construct($file_path)
    {
        $this->file_path = $file_path;
    }

    /**
     * Builds html string for display
     * @param $file_path
     * @param $params
     *
     * @since    1.0.0
     */
    public function render()
    {
        echo self::build_html($this->get_html(), $this->get_params());
    }

    public static function build_html($html, $params)
    {
        foreach ($params as $key => $param) {
            $search_string = '{{ $' . trim($key) . ' }}';
            $html = str_replace($search_string, $param, $html);
        }

        return $html;
    }

    public function get_html()
    {
        return file_get_contents($this->file_path);
    }

    public function get_params()
    {
        return get_object_vars($this);
    }
}