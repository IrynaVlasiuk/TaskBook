<?php

class AuthController extends ProtectedController
{
    private static $user;
    /**
     * Login user
     *
     * @param $userData
     */
    public static function loginUser($data)
    {
        $login = strip_tags($data["login"]);
        $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
        $login = htmlspecialchars($_POST['login'], ENT_QUOTES);

        $password = strip_tags($data["password"]);
        $password = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
        $password = htmlspecialchars($data["password"]);

        self::$user = PasswordHandler::getUser($login ,$password);
        self::validate($login ,$password);

        if(self::$formErrors == null){
            setcookie('jwt', self::generateJWT(self::$user[0]["id"]), time()+1800);
        } else {
            print_r(json_encode(self::getErrors()));
        }
    }

    private static function validate($login ,$password)
    {
        if(empty($login) || empty($password)) {
            array_push(self::$formErrors, 'All fields are required');
        } else{
            if(empty(self::$user)){
                array_push(self::$formErrors, 'Please enter valid email or password');
            } else {
                self::$formErrors = null;
            }
        }
        return self::$formErrors;
    }

    //registration admin
    public static function registerUser()
    {
        $username = 'admin';
        $email = 'admin';
        $password =  123;
        $hashPassword = PasswordHandler::setHashPassword($password);
        self::query("INSERT INTO users (name, email, password) VALUES ('$username', '$email', '$hashPassword')");
    }

    public static function logout()
    {
        setcookie('jwt', null);
        header("Location: index.php");
    }

}