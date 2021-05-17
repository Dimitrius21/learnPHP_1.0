<?php

print "order.php";
if (isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
  $user=$_SESSION['user'];
  $goods=[];    //Формируем массив доступного товара
  include_once 'mybase.php';
  $db=myBase::getDB();
  $st=$db->query("SELECT name_en FROM goods ORDER BY density", PDO::FETCH_ASSOC);
  while ($row=$st->fetch()) {
      $goods[]=$row['name_en'];
  }    

  $order=[];  // Формируем массив - товар=>объем
  foreach($_POST as $key=>$value) {
   if (in_array($key,$goods)) {
     $vol=trim($_POST[$key]);
     $order[$key]=$vol;
    }
  }
  $jsonOrder=json_encode($order);
  $month=trim($_POST['month']);
  //смотрим, есть ли уже в базе заказ от данного пользователя на указанный месяц 
  $st=$db->query("SELECT COUNT(*) as count FROM month_order WHERE month='$month' AND customer='$user'", PDO::FETCH_ASSOC);
  $ar=$st->fetch();
  //print_r($ar);             //если заказа нет - записываем, иначе меняем имеющийся
   if ( $ar['count'] > 0) { 
    echo $jsonOrder;
    $st=$db->prepare("UPDATE month_order SET zakaz=? WHERE month='$month' AND customer='$user'");
    $res=$st->execute(array($jsonOrder));
    if ($res) {print ("<p> ПереСохранено </p>");}
  }  else {
      $st=$db->prepare('INSERT INTO month_order (customer,zakaz,month) VALUE (?,?,?)');
      $res=$st->execute(array($user,$jsonOrder,$month));
      if ($res) {print ("<p> Сохранено </p>");}
  }
 
 print "<p> $_POST[month] </p>";
 foreach($order as $val){
  print "$val <br>";
 }
}
?>