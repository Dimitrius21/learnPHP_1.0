
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
    body {
        background-color: #00A;
        color: white;
    }
    div {
      width : 600px;
      border : 1px solid silver;
      tex-align : center;
    }
</style>

</head>

<body>
    <h2>Вход в систему</h2>
    <ul>
      <?php  
        foreach ($errors as $key => $error) {
          print "<li>$error</li>";
        }
      ?>  
    </ul>
 <div>   
 <form method="POST" action="">
  <p>
   <label for="login">Введите логин</label> 
   <input id="login" type="text" name="name" value="" >
  </p> 
  <p>
   <label for="pas">Введите пароль</label> 
   <input id="pas" type="password" name="password" value="" >
  </p> 
   <input type="submit" name="submit" value="Войти">
  </form>    
  </div>
</body>
</html>  