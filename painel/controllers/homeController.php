<?php
class homeController extends controller {

    public function __construct(){
        $usuarios = new Usuarios();

        if(!$usuarios->isLogged()) {
            header("location: ".BASE_URL.'login');
        }
    }

    public function index(){
       $dados = array(
           'cursos' =>array()
       );

       $cursos = new Cursos();
       $dados['cursos'] = $cursos->getCursos();
        
       $this->loadTemplate('home', $dados);
    }

    public function excluir($id) {

        $cursos = new Cursos();
        $cursos->excluirCurso($id);

        header("location: ".BASE_URL);
    }

    public function adicionar() {
        $dados = array();

        if(isset($_POST['nome']) && !empty($_POST['nome'])) {
            $nome = filter_input(INPUT_POST, 'nome');
            $descricao = filter_input(INPUT_POST, 'descricao');
            $imagem = $_FILES['imagem'];

            if(!empty($imagem['tmp_name'])) {

                $md5name = md5(time().rand(0,9999)).'.jpg';
                $types = array('image/jpeg', 'image/jpg', 'image/png');

                if(in_array($imagem['type'], $types)){
                    move_uploaded_file($imagem['tmp_name'], '../assets/images/cursos/'.$md5name);

                    $addCursos = new Cursos();
                    $addCursos->addCursos($nome, $descricao, $md5name);

                    header("location: ".BASE_URL);
                }

            }
        }

        $this->loadTemplate('curso_add', $dados);
    }

    public function editar($id) {
        $dados = array(
            'curso' => array(),
            'modulos' => array()
        );

        if(isset($_POST['nome']) && !empty($_POST['nome'])) {

            $nome = filter_input(INPUT_POST, 'nome');
            $descricao = filter_input(INPUT_POST, 'descricao');
            $imagem = $_FILES['imagem'];

            $update_text = new Cursos();
            $update_text->updateCurso($id, $nome, $descricao);

            if(!empty($imagem['tmp_name'])) {

                $md5name = md5(time().rand(0,9999)).'.jpg';
                $types = array('image/jpeg', 'image/jpg', 'image/png');

                if(in_array($imagem['type'], $types)){
                    move_uploaded_file($imagem['tmp_name'], '../assets/images/cursos/'.$md5name);

                    $update_img = new Cursos();
                    $update_img->updateImagemCurso($id, $md5name);
                }

            }

        }

            #Novo módulo foi adicionado
        $modulos = new Modulos();

        if(isset($_POST['modulo']) && !empty($_POST['modulo'])) {
            $modulo = filter_input(INPUT_POST, 'modulo');
            $modulos->addModulo($id, $modulo);
        }

        if(isset($_POST['aula']) && !empty($_POST['aula'])) {
            $aula = filter_input(INPUT_POST, 'aula');
            $moduloaula = filter_input(INPUT_POST, 'moduloaula');
            $tipoaula = filter_input(INPUT_POST,'tipo');

            $aulas = new Aulas();
            $aulas->addAula($id, $moduloaula, $aula, $tipoaula);
        }

        $cursos = new Cursos();
        $dados['curso'] = $cursos->getCurso($id);

        
        $dados['modulos'] = $modulos->getModulos($id);

        $this->loadTemplate('curso_edit', $dados);
    }


    public function del_modulo($id){

        $modulos = new Modulos();

        if(!empty($id)) {
            $id = addslashes($id);
            $id_curso = $modulos->getCurso($id);
            $modulos->deleteModulo($id);

            header("location: ".BASE_URL.'home/editar/'.$id_curso['id_curso']);
            exit;
        }

        header("location: ".BASE_URL);

    }

    public function edit_modulo($id) {
        $array = array();
        
        $modulos = new Modulos();

        if(isset($_POST['modulo']) && !empty($_POST['modulo'])) {
            $nome = filter_input(INPUT_POST, 'modulo');

            $id_curso = $modulos->getCurso($id);

            $modulos->updateModulo($id, $nome);

            header("location: ".BASE_URL.'home/editar/'.$id_curso['id_curso']);
            exit;
        }

        $array['modulo'] = $modulos->getModulo($id);

        $this->loadTemplate('curso_edit_modulo', $array);
    }

    public function del_aula($id) {

        if(!empty($id)) {
            $id = addslashes($id);

            $aulas = new Aulas();
            
            $id_curso = $aulas->getCurso($id);
            $aulas->deleteAula($id);

            header("location: ".BASE_URL.'home/editar/'.$id_curso['id_curso']);
            exit;
        }
        header("location: ".BASE_URL);
    }

    public function edit_aula($id) {
        $dados = array();
        $aulas = new Aulas();

        $view  = 'curso_edit_aula_video';

        if(isset($_POST['nome']) && !empty($_POST['nome'])) {

            $nome = filter_input(INPUT_POST, 'nome');
            $descricao = filter_input(INPUT_POST, 'descricao');
            $url = filter_input(INPUT_POST, 'url');

            $id_curso = $aulas->getCursoDeAula($id);

            $aulas -> updateVideoAula($id, $nome, $descricao, $url);

            header("location: ".BASE_URL.'home/editar/'.$id_curso['id_curso']);
            
        }

        if(isset($_POST['pergunta']) && !empty($_POST['pergunta'])) {

            $pergunta = filter_input(INPUT_POST, 'pergunta');
            $opcao1 = filter_input(INPUT_POST, 'opcao1');
            $opcao2 = filter_input(INPUT_POST, 'opcao2');
            $opcao3 = filter_input(INPUT_POST, 'opcao3');
            $opcao4 = filter_input(INPUT_POST, 'opcao4');
            $opcao5 = filter_input(INPUT_POST, 'opcao5');
            $resposta = filter_input(INPUT_POST, 'resposta');

            $id_curso = $aulas->getCursoDeAula($id);

            $aulas -> updateQuestionarioAula($id, $pergunta, $opcao1, $opcao2, $opcao3, $opcao4, $opcao5, $resposta);

            header("location: ".BASE_URL.'home/editar/'.$id_curso['id_curso']);
            
        }

        
        $dados['aula'] = $aulas->getAula($id);

        if($dados['aula']['tipo'] == 'video') {
            $view = 'curso_edit_aula_video';
        } else {
            $view = 'curso_edit_aula_poll';
        }

        $this->loadTemplate($view, $dados);
    }

}