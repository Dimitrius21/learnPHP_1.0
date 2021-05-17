<?php
session_start();
spl_autoload_register(function($class){
    $file=strtolower($class).".php";
    //$file=$class.".php";
    include_once ($file); }
);
//include 'myBase.php';

$routes=['admin'=>['adminController','init'],              //начальная страница для Админа 
         'admin/login'=>['adminController','login'],
         'admin/show'=>['adminController','monthOrder'],   //вывести заказ на месяц
         'admin/show/save/([0-9]{1,2})'=>['adminController','saveFileOrder'],  // сохранить заявки в .scv файл
         'dealer'=>['userController','init'],       //начальная страница для пользователя
         'dealer/login'=>['userController','login'],  
         'dealer/input'=>['userController','inputOrder'],  
         'dealer/input/save'=>['userController','inputSave'],  
         /*'show'=>['showController','showAll'],
         'show/([0-9]+)'=>['showController','showItem']*/
        ];


$dbd=myBase::getDB(); 

$routeExist=false;
$path=trim($_SERVER['REQUEST_URI'],'/');
foreach($routes as $key=>$value){
  $pattern="~".$key.'$~';
 if (1===preg_match($pattern,$path,$mathes)){ $routeExist=true; break;}
}
if ($routeExist) {
    //print($key.' - ');
    // print "Класс - {$routes[$key][0]}, метод - {$routes[$key][1]} <br>";  - тестовый показ вызываемого метода и класса
    $param=null;
    if (!empty($mathes[1])) $param=$mathes[1];
    call_user_func(array($routes[$key][0],$routes[$key][1]),$param);
} else print "путь не найден";


/*
$ar=['admin'=>[0=>'init', 'login'=>'login'],
     'show'=>'show'
];

echo $_SERVER['REQUEST_URI']."<br>";
$routes=explode('/',$path);
array_shift($routes);
$method=$ar[$routes[0]];
if (isset($method)) {var_dump($method);}
echo'<br>';

print_r($routes);

for($i=0;$i<count($routes);$i++) {
    $pattern="~".$routes[$i].'$~';
    if (1===preg_match($pattern,$path)){ $routeExist=true; break;}
   }
*/

