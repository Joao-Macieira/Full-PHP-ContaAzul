<?php

class ajaxController extends controller {

    public function __construct(){
       
        $alunos  = new Alunos();
        
        if(!$alunos->isLogged()) { 
            header("Location: ".BASE_URL."login");
		}
    }

    public function marcar_assistido($id) {
        $aulas = new Aulas();
        $aulas->marcarAssistido($id);
    }
}