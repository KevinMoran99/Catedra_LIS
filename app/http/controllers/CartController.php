<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 25/3/2018
 * Time: 4:48 PM
 */

namespace Http\Controllers;
use Http\Helpers as Helper;


class CartController
{
    public function kk ($id) {
        //Obteniendo objeto de store_page
        $page = (new StorePageController())->getPage($_POST['id'],false);
        if ($page == "Invalid") {
            die();
        }
        else {
            echo "xD";
        }
    }
}

try {
    //(new CartController())->kk($_POST['id']);
    //Obteniendo objeto de store_page
    $page = (new StorePageController())->getPage($_POST['id'],false);
    if ($page == "Invalid") {
        die();
    }
    else {
        echo "xD";
    }
}
catch (\Exception $e) {
    Helper\Component::showMessage(Helper\Component::$ERROR,$e);
}