<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
    body {
        background-color: #eee;
        color: black;
    }
    table { border-collapse : collapse;
    }
    tr, th { border : 1px solid black;
             padding : 2px 5px;
    } 
    p { padding : 2px;
        margin : 12px 5px 5px 5px;
    } 
    form { margin-top : 20px;
    }
    input {    color : blue;
               font-size : medium;
    }      
</style>
</head>
<body>
<?php
    $selMonth = $nextMonth>9 ? (string)$nextMonth : '0'.$nextMonth;
    $selMonth.='-'.date('Y');
    print "<p> Заявки на $selMonth</p>";
        for ($i=0; $i<count($ordes); $i++) {
            $r1=[];
            foreach ($ordes[$i][0] as $key => $value) {
                $r1[]=$goods[$key];
            }
            $r2=array_values($ordes[$i][0]);
            $r3=' <tr><th>'.implode('</th><th>',$r1).'</th></tr> ';
            $r4=' <tr><th>'.implode('</th><th>',$r2).'</th></tr> ';
            print "<p> {$ordes[$i][1]} </p>";
            print "<table> $r3 $r4 </table>";
        }
    $path="/izo/admin/show/save/".$nextMonth;
?>
  <form method="POST" action="<?php echo $path ?>">
    <input type="submit" name="submit" value="Cохранить таблицы в файл">
  </form>

  <p><a href="/izo/admin"> Вернуться на страницу администратора</a><p>
</body>
</html>
