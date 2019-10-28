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
        $data["user_name"] = addslashes($data["user_name"]);
        $user_name = htmlspecialchars($data["user_name"]);

        $data["user_email"] = addslashes($data["user_email"]);
        $user_email = htmlspecialchars($data["user_email"]);

        $data["description"] = addslashes($data["description"]);
        $description = htmlspecialchars($data["description"]);

        self::validation($user_name, $user_email, $description);

        if(empty(self::getErrors())){
            self::query("INSERT INTO tasks (user_name, user_email, description) VALUES ('$user_name', '$user_email', '$description')");
            setcookie("response-status", "OK", time() + 5);
            setcookie("response-message", "Task was successfully created", time() + 5);
            header("Location: " . $data["current_url"]);
        } else {
            setcookie("response-status", "ERROR", time() + 5);
            setcookie("response-message", "Task wasn`t created", time() + 5);
            header("Location: " . $data["current_url"]);
        }
    }

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
