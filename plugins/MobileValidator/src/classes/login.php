<?php
session_name('CAKEPHP');
session_start();

class LoggingIn {
    public static function IsLoggedin() {

        global $db;
        
        
        if(!isset($_SESSION['login'])) return -1;
        $sql = 'SELECT `user_name`, `password`, `id`
                FROM `sales_agent`
                WHERE `user_name`= \''.$_SESSION['login'].'\'';

        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);

        if($row['password'] == $_SESSION['password']) return $row['id'];

        return -1;
    }
    public static function LoginForm() {

        global $redirect;
        include "../forms/flogin.php";
    }

    public static function Login($login,$password) {
        global $db;

        if(!isset($login) || !isset($password))
            return -1;

        $sql = 'SELECT `user_name`, `password`, `id`
                FROM `sales_agent`
                WHERE `user_name`= \''.PostForm(PreSql($login)).'\'';

        if(!$result = $db->sql_query($sql))
            echo  "Error with mysql";


        $row = $db->sql_fetchrow($result);
        if($row['password'] ==  md5($password)) {
            $_SESSION['sales_agent_id']=$row['id'];
            $_SESSION['login']=$row['user_name'];
            $_SESSION['password']=$row['password'];
            $_SESSION['login_sales']=1;
            
            
            return $row['id'];
        }
        else
            return -1;
    }

    public static function LogOut() {
        unset($_SESSION['sales_agent_id']);
        unset($_SESSION['login']);
        unset($_SESSION['password']);
        unset ($_SESSION['login_sales']);
        unset($_SESSION);
    }

    public static function ForgotPassword() {
        //No thing yet
    }

}

?>