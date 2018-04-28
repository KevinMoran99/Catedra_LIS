<?php

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;

class Ban
{
    //Supuestamente retorna la ip de la maquina actual, sin importar proxies
    private static function getIp() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else{
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public static function isBanned() {
        //Limpiando bans viejos
        $query ="DELETE FROM bans WHERE DATE_ADD(ban_date, INTERVAL 24 HOUR) < NOW()";
        $params = array();
        Model\Connection::insertOrUpdate($query,$params);

        //Verificando si la ip actual esta baneada
        $query ="SELECT * FROM bans WHERE ip = ?";
        $params = array(Ban::getIp());
        $ban = Model\Connection::selectOne($query,$params);

        if($ban != null) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function ban() {
        //Si ya habia un ban vigente con esta ip, es eliminado para actualizarlo con el datetime actual
        $query ="DELETE FROM bans WHERE ip = ?";
        $params = array(Ban::getIp());
        Model\Connection::insertOrUpdate($query,$params);

        //Guardando ban
        $query ="INSERT INTO bans(ip, ban_date) VALUES (?,NOW())";
        $params = array(Ban::getIp());
        return Model\Connection::insertOrUpdate($query,$params);
    }
}