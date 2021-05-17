<?php
class adminController {
    public static function init(){
        if (self::checkAdmin()) {
        echo "<p> $_SESSION[role] - $_SESSION[login] </p>";
        print '  <p><a href="izo/admin/show">Просмотреть заявки</a></p>
                 <p><a href="logout.php">Выйти из системы</a></p>';
        } else {
                print ('<p> <a href="admin/login">Войти в систему</a></p>');                
        }
    }
    public static function login(){
        $table='users';
        $role="admin";
        $route='/izo/admin';
        require_once "login.php";
    }

    public static function monthOrder(){

        if (!self::checkAdmin()) {  exit("Доступ запрещен");  }
        $nextMonth=((int)date('m')+1)%12; //вычистить следующий месяц
        //print "$selMonth <br>";

        list($goods, $ordes)=self::getData($nextMonth);
                //вывод по компаниям
//        print_r ($ordes);
        include ('order_view.php');
       /* for ($i=0; $i<count($ordes); $i++) {
            $r1=[];
            foreach ($ordes[$i][0] as $key => $value) {
                $r1[]=$goods[$key];
            }
            //$r1=array_keys($ordes[$i][0]);
            $r2=array_values($ordes[$i][0]);
            $r3=' <tr><th>'.implode('</th><th>',$r1).'</th></tr> ';
            $r4=' <tr><th>'.implode('</th><th>',$r2).'</th></tr> ';
            print "<p> {$ordes[$i][1]} </p>";
            print "<table> $r3 $r4 </table>";
        }*/
    }

    public static function saveFileOrder($month){
     if (!self::checkAdmin()) {exit("Доступ запрещен");}
      list($goods, $ordes)=self::getData($month);
      header('Content-Type: application/csv');
      $filename="companies{$month}.csv";
      header('Content-Disposition: attachment;filename="'.$filename.'"');
        for ($i=0; $i<count($ordes); $i++) {
            $r1=[];
            foreach ($ordes[$i][0] as $key => $value) {
                $r1[]=$goods[$key];  
            }
            $r2=array_values($ordes[$i][0]);
            $r3=implode(';', $r1);
            $r4=implode(';', $r2);
            $str = mb_convert_encoding($ordes[$i][1], "Windows-1251");
            print "$str\n";
            $str = mb_convert_encoding($r3, "Windows-1251");
            print "$str\n";
            $str = mb_convert_encoding($r4, "Windows-1251");
            print "$str\n";
        }
        //header('Location: izo/admin');
    }

    public static function getData(int $month){
        $db=myBase::getDB();
        //получить массив имеющегося товара
        $keys=[];
        $values=[];
        $st2=$db->query("SELECT name_en, name_ru FROM goods", PDO::FETCH_ASSOC);
        //$goods=$st2->fetchAll();
        while ($row=$st2->fetch()){ 
            $keys[]=$row['name_en'];
            $values[]=$row['name_ru'];
        }    
        $goods=array_combine($keys,$values);
        //print_r($goods);  
        
        // Получить заявки по выбранному месяцу
        $selMonth = $month>9 ? (string)$month : '0'.$month;
        $selMonth= date('Y')."-$selMonth";
        $st=$db->prepare("SELECT month_order.zakaz, users.company FROM month_order
                          INNER JOIN users
                          ON (month_order.customer=users.id)
                          WHERE month_order.month=:date");
        $st->bindParam(':date',$selMonth);
        $st->execute();
        $ordes=[];
        $i=0;
        while ($row=$st->fetch(PDO::FETCH_ASSOC)){
               $ordes[$i][]=json_decode($row['zakaz'],true);
               $ordes[$i][]=$row['company'];
               $i++;
            }
        //print_r($ordes);
        return array($goods, $ordes);
    }

    public static function checkAdmin(){
        if (isset($_SESSION['user']) and !empty($_SESSION['user']) and $_SESSION['role']=='admin') {return true;}
         else {return false;}
    }
}