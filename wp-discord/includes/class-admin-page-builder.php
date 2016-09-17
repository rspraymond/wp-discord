<?php

class AdminPageBuilder
{
    /**
     * Path to html file
     * @var $file_path
     */
    protected $file_path;
    public $forbidden = ['file_path', 'forbidden'];

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
        try {
            include($this->file_path);
        } catch (Exception $ex) {
            echo 'ERROR: ' . $ex->getMessage();
        }
    }
}