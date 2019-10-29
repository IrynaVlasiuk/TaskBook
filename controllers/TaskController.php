<?php


class TaskController extends ProtectedController
{
    /**
     * Add new task
     *
     * @param $data
     * @return false|string
     */
    public static function create($data)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("HTTP/1.1 200 OK");
        $data["user_name"] = addslashes($data["user_name"]);
        $user_name = htmlspecialchars($data["user_name"]);

        $data["user_email"] = addslashes($data["user_email"]);
        $user_email = htmlspecialchars($data["user_email"]);

        $data["description"] = addslashes($data["description"]);
        $description = htmlspecialchars($data["description"]);

        self::validation($user_name, $user_email, $description);

        $response = new stdClass();

        if(empty(self::getErrors())){
            self::query("INSERT INTO tasks (user_name, user_email, description) VALUES ('$user_name', '$user_email', '$description')");
            $response->isSuccess = true;
            $response->message = "Task was successfully created";
            $_SESSION["response_data"] = serialize($response);
            header("Location: " . $data["current_url"]);
        } else {
            $response->isSuccess = false;
            $response->message = "Task wasn`t created";
            $_SESSION["response_data"] = serialize($response);
            header("Location: " . $data["current_url"]);
        }
    }

    /**
     * @param $data
     */
    public static function changeStatusTask($data)
    {
        if(!is_numeric($data["task_id"])) {
            die();
        }

        $task_id = $data["task_id"];

        $data["done"] = addslashes($data["done"]);
        $done = htmlspecialchars($data["done"]);

        self::query("UPDATE tasks SET done = '$done' WHERE id='$task_id'");
    }

    /**
     * @param $user_name
     * @param $user_email
     * @param $description
     * @return array
     */
    private static function validation($user_name, $user_email, $description)
    {
        if(empty($user_name) || empty($user_email) || empty($description)) {
            array_push(self::$formErrors, 'All fields are required');
        } else {
            self::$formErrors = array();
        }
        return self::$formErrors;
    }
}
