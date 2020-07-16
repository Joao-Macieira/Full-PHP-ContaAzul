<?php

class controller {

    public function loadView($viewName, $viewData = array()){
        #pega os indices do array e transforma em várias, mantendo seu valor
        extract($viewData);
        
        #faz a requisição da página no arquivo views
        require 'views/'.$viewName.'.php';

    }

    public function loadTemplate($viewName, $viewData = array()){
        require 'views/template.php';
    }

    public function loadViewInTemplate($viewName, $viewData = array()){
        extract($viewData);
        require 'views/'.$viewName.'.php';
    }



}





?>