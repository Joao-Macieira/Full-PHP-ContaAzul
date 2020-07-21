<?php

class Cursos extends model {

    private $info;

    public function getCursosDoAluno($id) {
        $array = array();

        $sql = "SELECT aluno_curso.id_curso, cursos.nome, cursos.imagem, cursos.descricao FROM aluno_curso LEFT JOIN cursos ON aluno_curso.id_curso = cursos.id WHERE aluno_curso.id_aluno = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;

    }

    public function setCurso($id) {

        $sql = "SELECT * FROM cursos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $this->info = $sql->fetch(PDO::FETCH_ASSOC);
        }

    }

    public function getNome(){
        return $this->info['nome'];
    }

    public function getImagem() {
        return $this->info['imagem'];
    }

    public function getDescricao() {
        return $this->info['descricao'];
    }

    public function getId() {
        return $this->info['id'];
    }

    public function getTotalAulas() {

        $sql = "SELECT id FROM aulas WHERE id_curso = :id_curso";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_curso", $this->getId());
        $sql->execute();
        
        return $sql->rowCount();
    }

}