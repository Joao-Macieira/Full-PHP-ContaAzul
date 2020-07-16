<?php
class homeController extends controller {

    public function __construct(){
       
        $alunos  = new Alunos();
        
        if(!$alunos->isLogged()) {
            
            header("Location: ".BASE_URL."login");
            
		}

    }

    public function index(){
       $dados = array();


       
       $this->loadTemplate('home', $dados);
    }  
}