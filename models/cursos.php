<?php

class Cursos extends model {

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

}