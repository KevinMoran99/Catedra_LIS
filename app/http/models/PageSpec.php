<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 10/3/2018
 * Time: 8:55 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class PageSpec implements Interfaces\ModelInterface, \JsonSerializable
{
    private $id;
    private $storePage;
    private $spec;
    private $state;

    /**
     * PageSpec constructor.
     * @param $id
     * @param $storePage
     * @param $spec
     * @param $state
     */
    public function init($id, $storePage, $spec, $state)
    {
        $this->id = $id;
        $this->storePage = $storePage;
        $this->spec = $spec;
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStorePage()
    {
        return $this->storePage;
    }

    /**
     * @param mixed $storePage
     */
    public function setStorePage($storePage)
    {
        $this->storePage = $storePage;
    }

    /**
     * @return mixed
     */
    public function getSpec()
    {
        return $this->spec;
    }

    /**
     * @param mixed $spec
     */
    public function setSpec($spec)
    {
        $this->spec = $spec;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }


    public function getAll($active = false)
    {
        //Innecesario
        return "Este método es innecesario";
    }

    public function getById()
    {
        $query ="SELECT * FROM page_specs WHERE id = ?";
        $params = array($this->getId());
        $pageSpec = Model\Connection::selectOne($query,$params);
        $this->setId($pageSpec['id']);
            $pStorePage = new StorePage();
            $pStorePage->setId($pageSpec['store_page_id']);
            $pStorePage->getById();
        $this->setStorePage($pStorePage);
            $pSpec = new Spec();
            $pSpec->setId($pageSpec['spec_id']);
            $pSpec->getById();
        $this->setSpec($pSpec);
        $this->setState($pageSpec['state']);
    }

    //Determina si el spec ya fue agregado a esa storepage
    public function isRepeated()
    {
        $query ="SELECT * FROM page_specs WHERE store_page_id = ? AND spec_id = ?";
        $params = array($this->getStorePage()->getId(), $this->getSpec()->getId());
        $pageSpec = Model\Connection::selectOne($query,$params);
        if (empty($pageSpec)) {
            return false;
        }
        else {
            return true;
        }
    }

    public function getByPage(StorePage $pStorePage, $active = false){
        if ($active)
            $query ="SELECT * FROM page_specs WHERE store_page_id = ? AND state = 1";
        else
            $query ="SELECT * FROM page_specs WHERE store_page_id = ?";
        $params = array($pStorePage->getId());
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pStorePage = (new StorePage());
            $pStorePage->setId($line["store_page_id"]);
            $pStorePage->getById();

            $pSpec = (new Spec());
            $pSpec->setId($line["spec_id"]);
            $pSpec->getById();

            //Registro
            $pageSpec = (new PageSpec());
            $pageSpec->init($line["id"], $pStorePage,$pSpec, $line["state"]);

            array_push($result, $pageSpec);
        }
        return $result;
    }

    public function insert()
    {
        $query ="INSERT INTO page_specs (store_page_id,spec_id,state) VALUES(?,?,?)";
        $params= array($this->getStorePage()->getId(),$this->getSpec()->getId(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update()
    {
        $query ="UPDATE page_specs SET store_page_id = ?, spec_id = ?, state = ? WHERE id = ?";
        $params= array($this->getStorePage()->getId(),$this->getSpec()->getId(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function delete()
    {
        $query ="DELETE FROM page_specs WHERE id = ?";
        $params= array($this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param)
    {
        // Innecesario
        return "Método innecesario";
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'store_page' =>[
                'id' => $this->getStorePage()->getId(),
                'game' => [
                    'id' => $this->getStorePage()->getGame()->getId(),
                    'name' => $this->getStorePage()->getGame()->getName(),
                    'cover' => $this->getStorePage()->getGame()->getCover(),
                    'banner'=>$this->getStorePage()->getGame()->getBanner(),
                    'description' => $this->getStorePage()->getGame()->getDescription(),
                    'esrb' => [
                        'id' => $this->getStorePage()->getGame()->getEsrb()->getId(),
                        'name' => $this->getStorePage()->getGame()->getEsrb()->getName(),
                    ],
                    'publisher' => [
                        'id' => $this->getStorePage()->getGame()->getPublisher()->getId(),
                        'name' => $this->getStorePage()->getGame()->getPublisher()->getName(),
                    ],
                    'genre' => [
                        'id' => $this->getStorePage()->getGame()->getGenre()->getId(),
                        'name' => $this->getStorePage()->getGame()->getGenre()->getName(),
                    ],
                ],
            ],
            'spec' => [
                'id' => $this->getSpec()->getId(),
                'name' => $this->getSpec()->getName(),
                'type_spec' => [
                    'id' => $this->getSpec()->getTypeSpec()->getId(),
                    'name' => $this->getSpec()->getTypeSpec()->getName()
                ],
            ],
            'state'=>$this->getState(),
        ];
    }
}