<?php
class Validate{
    //private $errors;
    private static $types=['required', 'int', 'float', 'email', 'min'];
    private static $errMessage=['required'=>"поле должно быть заполнено",
                         'int'=>"значение в поле должно быть целочисленным значением",
                         'float'=>"значение в поле должно быть числом",
                         'email'=>"значение в поле должно быть адресом электронной почты",];
    /*
        *на входе массив проверяемых типов, имя переменной, указание на массив GET or POST
        *возвращаем false, если ошибка в названии проверяемого типа или некорректный входной массив, 
        *true если все ок или массив выявленных ошибок
    */
    public static function check(Array $validType, $name, $where="POST"){
        $errors=[];
        $res=true;
        if ($where=='POST') $path=INPUT_POST;
         elseif ($where=='GET') $path=INPUT_GET;
         else { return "только в массивах GET или POST";} 
         $where='_'.$where;
        foreach($validType as $type){
          if (in_array($type, self::$types)) { 
           switch ($type) {
            case 'required' : { 
                $val= ($where="POST") ? $_POST[$name] : $_GET[$name];
                if ( empty($val)) { 
                    $errors[]=self::$errMessage['required'];
                    $res=false;}  break;}
            case 'int' : { 
                if (false===filter_input($path, $name, FILTER_VALIDATE_INT)) { 
                    $errors[]=self::$errMessage['int']; 
                    $res=false;}  break;}
            case   'float' : { 
                if (false===filter_input($path, $name, FILTER_VALIDATE_FLOAT)) { $errors[]=self::$errMessage['float'];
                    $res=false;}  break;}
            case   'email' : { 
                if (false===filter_input($path, $name, FILTER_VALIDATE_EMAIL)) { $errors[]=self::$errMessage['email'];
                    $res=false;}  break;}
            case 'min' : {  
                break;}   
          } //switch
         } else return false;  
        } //foreach
        if ($res)  return true;
         else { return $errors;}
    }
}

