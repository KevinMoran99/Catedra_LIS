<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 25/3/2018
 * Time: 4:48 PM
 */

namespace Http\Controllers;
require ("../../../vendor/autoload.php");
use Http\Helpers as Helper;

class CartController
{
    public function getSubtotal($key) {
        if (!session_id()) {
            session_start();
        }
        $price = $_SESSION['cart'][$key][0]->getPrice();
        $discount = $_SESSION['cart'][$key][0]->getDiscount();
        $quantity = $_SESSION['cart'][$key][1];

        return ($price - ($price * $discount / 100)) * $quantity;
    }

    public function getTotal() {
        if (!session_id()) {
            session_start();
        }
        $total = 0;
        foreach ($_SESSION['cart'] as $key => $item) {
            $total += $this->getSubtotal($key);
        }
        return $total;
    }

    //Añadiento item a carrito
    public function addItem ($id) {
        //Obteniendo objeto de store_page
        $page = (new StorePageController())->getPage($id,false);
        if ($page == "Invalid") {
            die();
        }
        else {
            //Reanudando sesion
            session_start();

            $repeated = false;
            $repeatedId = 0;
            //Determinando si el item ya estaba en el cart
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item[0]->getId() == $id) {
                    $repeated = true;
                    $repeatedId = $key;
                }
            }

            //Si el item ya estaba en el cart, se incrementa su cantidad
            if ($repeated) {
                if ($_SESSION['cart'][$repeatedId][1] < 20) {
                    $_SESSION['cart'][$repeatedId][1]++;
                }
            } //Si el item no estaba, se añade al cart con cantidad 1
            else {
                $array = [$page, 1];
                $_SESSION['cart'][$page->getId()] = $array;
            }
            //$_SESSION['cart'] = [];
            //echo json_encode($_SESSION['cart']);
        }
    }

    //Actualizando cantidad de item de carrito
    public function addQuant($id, $quantity) {
        //Normalizando limites
        if ($quantity > 20) {
            $quantity = 20;
        }
        if ($quantity < 1) {
            $quantity = 1;
        }

        //Obteniendo objeto de store_page
        $page = (new StorePageController())->getPage($id,false);
        if ($page == "Invalid") {
            die();
        }

        //Reanudando sesion
        session_start();
        $array = [$page, $quantity];
        $_SESSION['cart'][$page->getId()] = $array;

        //Devuelve un array conteniendo el nuevo subtotal del item, y el total global
        echo json_encode([number_format($this->getSubtotal($id),2),number_format($this->getTotal(),2)]);
    }

    //Eliminando objeto de carrito
    public function delItem($id) {
        session_start();
        unset($_SESSION['cart'][$id]);

        //Devuelve el total global
        echo number_format($this->getTotal(),2);
    }

    //Limpiando carrito
    public function clearCart() {
        session_start();
        $_SESSION['cart'] = [];
    }
}

try
{
    if (isset($_POST["method"])) {
        if ($_POST["method"] == "addItem") {
            (new CartController())->addItem($_POST['id']);
        }

        else if ($_POST["method"] == "addQuant") {
            (new CartController())->addQuant($_POST['id'], $_POST['quant']);
        }

        else if ($_POST["method"] == "delItem") {
            (new CartController())->delItem($_POST['id']);
        }

        else if ($_POST["method"] == "clearCart") {
            (new CartController())->clearCart();
        }
    }

}
catch (\Exception $e) {
    Helper\Component::showMessage(Helper\Component::$ERROR,$e);
}