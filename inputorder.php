<?php
//session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    $url='/izo/dealer';        //'http://'.$_SERVER['SERVER_NAME'].'/izo/dealer';
    header("Location: $url");              
}

// include_once 'mybase.php';
$con=myBase::getDB();
$st=$con->query('SELECT * FROM goods',PDO::FETCH_ASSOC);
$i=0;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Document</title>
   <style>
    body {
        background-color: blue;
        color: white;
    }
    table {
        border-collapse: collapse;
    }
    td,
    th {
        border: 1px solid silver;
    }
  </style>
</head>
<body>
    <h2>Заявка на поставку продукции в</h2>
    <form method="POST" action="dealer/input/save">
        <p>Месяц: <input type="month" name="month"> </p>
        <table>
            <tr>
                <th>Наименование продукции</th>
                <th>Объем, м3</th>
                <th>Вес,т</th>
            </tr>
        <?php
        while ($row=$st->fetch()) {
            print "<tr>
                <td>$row[name_ru]: </td>
                <td><input type=".'number" size="6" name="'. $row['name_en'].'" date-dest="'.$row['density'].'" value="" id="in'.$i.'"></td>
                <td></td>
              </tr>';
            $i++;
        }
        ?>    
        </table>
        <p> Итого: <span> 0</span> т</p>
        <input type="submit" name="submit" value="Отправить заявку">
    </form>

    <script>
        function calc(elem) {
            let dest = parseInt(elem.getAttribute('date-dest'));
            let vol = (elem.value) ? elem.value : 0;
            let ind = parseInt(elem.id.substr(2));
            ar[ind] = vol * dest / 1000;
            elem.parentNode.parentNode.querySelectorAll('td')[2].innerHTML = ar[ind];
            console.log(ar);
            sumVol = ar.reduce((total, item) => {
                return total + item
            });
            //sumVol += vol * dest;
            span.innerHTML = sumVol;
        }

        function keyHandle(ev) {
            console.log()
            if (13 == ev.keyCode) {
                ev.preventDefault();
                calc(ev.target);
            }
        }

        function blurHandle(ev) {
            calc(ev.target);
        }

        var sumVol = 0;
        var ar = [];
        const span = document.querySelector('span');
        const inp = document.querySelectorAll('input[date-dest]');

        // вешаем обработчики на события - смена фокуса/нажатие клавиши(анализ только Ввод) 

        inp.forEach((elem) => {
            elem.addEventListener("blur", blurHandle);
            elem.addEventListener("keydown", keyHandle);
        });
    </script>
</body>
</html>

<?php
