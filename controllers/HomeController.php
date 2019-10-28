<?php


class HomeController extends ProtectedController
{
    public static function index($page, $column, $order)
    {
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

        return self::renderView('home', $data, $page, $total_pages);
    }
}