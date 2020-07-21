<?php
    #base do site
class Core{

    public function run(){

        $url = '/';

        if(isset($_GET['url'])){
            $url .= $_GET['url'];
        }

        $params = array();

        if(!empty($url) && $url != '/'){
                #pega a url e transforma em array
            $url = explode('/', $url);
                #tira o primeiro termo do array
            array_shift($url);
                #define o controller utilizado
            $currentController = $url[0].'Controller';
            array_shift($url);
                #define a action utilizada com proteção para ter ou não o parametro na url
            if(isset($url[0]) && !empty($url[0])){
                $currentAction = $url[0];
                array_shift($url);
            } else {
                $currentAction = 'index';
            }
            
            
            if(count($url) > 0){
                $params = $url;
            }

        } else {
            $currentController = 'homeController';
            $currentAction = 'index';
        }

        #cria a classe e usa as funções com parametros

        $c =  new $currentController();
        call_user_func_array(array($c, $currentAction), $params);


    }

}


?>