<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15/3/2018
 * Time: 10:28 AM
 */

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;


class UserTypeController
{
    //OBTENER TODOS LOS REGISTROS
    public function getAllUserTypes(){
        //creamos un nuevo objeto
        $userType = new Model\UserType();
        //retornamos todos los datos
        return $userType->getAll();
    }

    //Obtener todos los registros activos
    public function getAllActiveUserTypes(){
        //creamos un nuevo objeto
        $userType = new Model\UserType();
        //retornamos todos los datos
        return $userType->getAll(true);
    }
}