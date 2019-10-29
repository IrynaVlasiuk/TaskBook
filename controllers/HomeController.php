<?php


class HomeController extends ProtectedController
{
    /**
     * @param $page
     * @param $column
     * @param $order
     */
    public static function index($page, $column, $order)
    {
        session_start();
        $response = null;
        if(isset($_SESSION['response_data'])) {
            $response = unserialize($_SESSION['response_data']);
            $_SESSION['response_data'] = null;
        }

        $records_per_page = 3;
        $page = $page == NULL ? 1: $page;
        $offset = ($page-1) * $records_per_page;
        $total_pages_sql = (int)self::query("SELECT COUNT(*) FROM tasks");
        $total_pages = (int)ceil($total_pages_sql / $records_per_page);

        if(!empty($column) && !empty($order)) {
            $data =  self::query("SELECT * FROM tasks ORDER BY ". $column ." ". $order." LIMIT ".$offset.",". $records_per_page);
        } else {
            $data =  self::query("SELECT * FROM tasks GROUP BY id LIMIT ".$offset.",". $records_per_page);
        }

        if(isset($_COOKIE['jwt'])){
           if(JWT::checkValidation($_COOKIE['jwt'])) {
               $obj = JWT::checkValidation($_COOKIE['jwt']);
               if($obj->user_email == 'admin') {
                   $isAdmin = true;
               }
           }
        }
        return self::renderView('home', $data, $page, $total_pages, $response, $isAdmin);
    }
}