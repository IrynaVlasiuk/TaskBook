<?php


class AdminController extends ProtectedController
{
    /**
     * @param $request
     * @return mixed
     */
    public static function editTask($request)
    {
        self::authorize();

        $response = new Response();

        if(!is_numeric($request["task_id"])) {
            die();
        }
        $task_id = $request["task_id"];
        $request["description"] = addslashes($request["description"]);
        $description = htmlspecialchars($request["description"]);

        self::query("UPDATE tasks SET description = '$description', edited = 1 WHERE id='$task_id'");
        $result =  self::query("SELECT * FROM tasks AS t WHERE t.id = '$task_id'");

        $response->status = 'OK';
        $response->data = $result;

        return print_r(json_encode($response));
    }
}