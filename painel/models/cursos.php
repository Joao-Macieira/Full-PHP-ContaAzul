<?php

class Cursos extends model {

    public function getCursos() {
        $array = array();

        $sql = "SELECT *,(select count(*) from aluno_curso where aluno_curso.id_curso = cursos.id) as qtalunos FROM cursos";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getCurso($id) {
        $array = array();

        $sql = "SELECT * FROM cursos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getCursosInscritos($id_aluno) {
        $array = array();

        $sql = "SELECT id_curso FROM aluno_curso WHERE id_aluno = :id_aluno";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_aluno", $id_aluno);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row) {
                $array[] = $row['id_curso'];
            }
        }

        return $array;
    }

    public function matricularAluno($id, $disciplina) {

        $sql = "INSERT INTO aluno_curso (id_curso, id_aluno) VALUES (:id_curso, :id_aluno)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_curso", $disciplina);
        $sql->bindValue(":id_aluno", $id);
        $sql->execute();

    }

}