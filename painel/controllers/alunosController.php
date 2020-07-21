<?php

class alunosController extends controller {

    public function __construct(){
        $usuarios = new Usuarios();

        if(!$usuarios->isLogged()) {
            header("location: ".BASE_URL.'login');
        }
    }

    public function index() {
        $dados = array(
            'alunos' => array()
        );

        $alunos = new Alunos();
        $dados['alunos'] = $alunos->getAlunos();

        $this->loadTemplate('alunos', $dados);
    }

    public function excluir($id) {

        $alunos = new Alunos();
        $alunos->excluirAluno($id);

        header("location: ".BASE_URL.'alunos');
    }

    public function adicionar() {
        $dados = array();
        
        if(isset($_POST['nome']) && !empty($_POST['nome'])) {

            $nome = filter_input(INPUT_POST,'nome');
            $email = filter_input(INPUT_POST,'email');
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            $alunos = new Alunos();
            $alunos->matricular($nome, $email, $senha);

            header("location: ".BASE_URL.'/alunos');
        }

        $this->loadTemplate('add_aluno', $dados);
    }

    public function editar($id) {
        $dados = array(
           'aluno' => array(),
           'modulos' => array()
        );
        $alunos = new Alunos();
        $curso = new Cursos();

        if(isset($_POST['nome']) && !empty($_POST['nome'])) {

            $nome = filter_input(INPUT_POST, 'nome');
            $email = filter_input(INPUT_POST, 'email');
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            
            $alunos->updateAluno($id, $nome, $email, $senha);
            $alunos->resetarCurso($id);

            if(!empty($_POST['cursos'])) {
                $cursos = $_POST['cursos'];

                foreach ($cursos as $disciplina) {
                    $curso->matricularAluno($id, $disciplina);
                }
            } else {
                $cursos = array();
            }
        }

        
        $dados['aluno'] = $alunos->getAluno($id);
        $dados['cursos'] = $curso->getCursos();
        $dados['inscrito'] = $curso->getCursosInscritos($id);

        $this->loadTemplate('editar_aluno', $dados);
    }

}