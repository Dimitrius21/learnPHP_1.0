<?php
class userController {
    public static function init(){
        if (!self::checkUser()) {
            print ('<p> <a href="dealer/login">Войти в систему</a></p>');    /*<p><a href="">Зарегистрироваться</a></p>*/
        } else {
             print "<p> $_SESSION[login] </p>";
             print '  <p><a href="dealer/input">Оформить заявку на предстоящий месяц</a></p>
             <p><a href="logout.php">Выйти из системы</a></p>';
            }    
    }

    public static function login(){
        $table='users';
        $role="user";
        $route='/izo/dealer';
        require_once "login.php";
    }

    public static function inputOrder(){
        require_once 'inputorder.php';
    }
    public static function inputSave(){
        require_once 'order.php';
    }
    public static function checkUser() {
        if (isset($_SESSION['user']) and !empty($_SESSION['user'])) {return true;}
         else {return false;}
    }
}