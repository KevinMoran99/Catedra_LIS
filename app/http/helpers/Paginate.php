<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 10/03/2018
 * Time: 13:17
 */

namespace Http\Helpers;


class Paginate
{
    private $items_per_page = 10;
    private $items = null;
    private $current_page = 1;

    /**
     * Paginate constructor.
     * @param int $items_per_page
     * @param null $items
     * @param null $current_page
     */
    public function __construct($items, $current_page)
    {
        $this->items = $items;
        $this->current_page = $current_page;
    }

    public function linksNumber(){
        return ceil($this->items/$this->items_per_page);
    }

    public function getData(){
        $min = ($this->current_page - 1)*10;
        $data=array();

        for($i=0;$i<10;$i++){
            $min+=1;
            array_push($data,$this->items[$min]);
        }
        return $data;
    }

}