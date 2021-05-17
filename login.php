<?php
  //$myValidate = new Validate;
  $errors=[];
  if ($_SERVER['REQUEST_METHOD']=='POST') {
    $res=Validate::check(['required'],'name');
    if(is_array($res)) { $errors[]="Логин - ".$res[0];}
    $res=Validate::check(['required'],'password');
    if(is_array($res)) {$errors[]="Пароль - ".$res[0];}
    if (!$errors) {
       $db=myBase::getDB(); 
       $st=$db->prepare("SELECT id, name, password FROM $table WHERE name=?");
       $st->execute(array($_POST['name']));
       $res=$st->fetchAll();
       //print_r($res);
       $col=count($res);
       if ($col>0 /*&& password_verify($pas, $res[0]['password']*/) {   //пока без проверки пароля
          $_SESSION['user']=$res[0]['id'];
          $_SESSION['login']=$res[0]['name'];
          //$url=$_SESSION['url'];
          $_SESSION['role']=$role;
          header("Location: $route");
       } else { print ("<h3>Неверно введено логин/пароль</h3>"); } 
    }  
  }   

include 'login_view.php';

?>