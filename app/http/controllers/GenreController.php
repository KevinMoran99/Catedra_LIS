<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 11/03/2018
 * Time: 7:06
 */

namespace Http\Controllers;

//require ("../../../vendor/autoload.php");
use Http\Models as Model;

class GenreController
{
    public function getAllGenres(){
        $genres = new Model\Genre();
        return $genres->getAll();
    }
}