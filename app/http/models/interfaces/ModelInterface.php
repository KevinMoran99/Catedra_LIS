<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 10:46 PM
 */

namespace Http\Models\Interfaces;
require ("../../../../vendor/autoload.php");

interface ModelInterface
{
    public function getAll();
    public function getById();
    public function insert();
    public function update();
    public function search($param);
}