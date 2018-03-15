<?

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;

Class GameController
{
    public function getAllGames(){
        $game= new Model\Game();
        return $game->getAll();
    }

    public  function  addGame($name, $cover, $description, $esrb, $publisher, $genre, $platform, $state){
        //instancia
        $validator = new Helper\Validator();
        $game = new Model\Game();
        //variables de validacion
        $flag = false;
        $validateError= "";

        //validamos si es alfanumerico
        if(!$validator->validateImage($cover,3,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de plataforma";
            $flag=true;
        }

        //validamos
        if(!$flag) {
            $platform->setName($name);
            $platform->setState($state);
            $response = $platform->insert();

            //mostramos mensaje de error
            if(is_bool($response)){
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Plataforma añadido");
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }
}