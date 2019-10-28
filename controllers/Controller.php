<?php

class Controller extends Repository
{
    protected static $formErrors = array();
    /**
     * @param $viewName
     */
    public static function renderView($viewName, $data = "", $page = 1, $total_pages = 1, $response = null)
    {
        require_once 'views/'.$viewName.'.php';
    }
    /**
     * @return array
     */
    public static function getErrors()
    {
        return self::$formErrors;
    }
}
