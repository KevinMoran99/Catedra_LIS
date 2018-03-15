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
    private $items_per_page = 12;
    private $items = null;
    private $current_page = 1;

    /**
     * Paginate constructor.
     * @param null $items
     * @param null $current_page
     */
    public function __construct($items, $current_page)
    {
        $this->items = $items;
        if(is_numeric($current_page)){
            $this->current_page = $current_page;
        }else{
            $this->current_page = 1;
        }
    }

    public function linksNumber(){
        return ceil(sizeof($this->items)/$this->items_per_page);
    }

    public function getData(){
        $min = ($this->current_page - 1)*$this->items_per_page;
        $data=array();

        for($i=0;$i<$this->items_per_page;$i++){
            if($min < sizeof($this->items)) {
                array_push($data, $this->items[$min]);
                $min += 1;
            }
        }
        return $data;
    }

}