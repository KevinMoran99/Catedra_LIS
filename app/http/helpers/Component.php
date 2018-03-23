<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 11/3/2018
 * Time: 4:03 PM
 */

namespace Http\Helpers;

class Component
{
    //Variables que indican el tipo de mensaje a mostrar
    public static $SUCCESS = 1;
    public static $ERROR = 2;
    public static $WARNING = 3;
    public static $INFO = 4;

    public static function showMessage($type, $message){
        //Si se le pasa como parámetro un valor numérico (proveniente de una excepcion mysql), interpretará ese valor
        if(is_numeric($message)){
            switch($message){
                case 1045:
                    $text = "Autenticación desconocida";
                    break;
                case 1049:
                    $text = "Base de datos desconocida";
                    break;
                case 1054:
                    $text = "Nombre de campo desconocido";
                    break;
                case 1062:
                    $text = "Dato duplicado, no se puede guardar";
                    break;
                case 1146:
                    $text = "Nombre de tabla desconocido";
                    break;
                case 1451:
                    $text = "Registro ocupado, no se puede eliminar";
                    break;
                case 2002:
                    $text = "Servidor desconocido";
                    break;
                default:
                    $text = $message;
            }
        }else{
            //Si el parámetro es un string normal, se imprimirá eso sin mas
            $text = $message;
        }

        //Determinando el ícono y título
        switch($type){
            case Component::$SUCCESS:
                $title = "Éxito";
                $icon = "success";
                break;
            case Component::$ERROR:
                $title = "Error";
                $icon = "error";
                break;
            case Component::$WARNING:
                $title = "Advertencia";
                $icon = "warning";
                break;
            case Component::$INFO:
                $title = "Aviso";
                $icon = "info";
                break;
        }

        echo $title . "|" . $text . "|" . $icon;

    }
}