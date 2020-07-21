<?php

class Alunos extends model {

    public function getAlunos() {
        $array = array();

        $sql = "SELECT *,(select count(*) from aluno_curso where aluno_curso.id_aluno = alunos.id) as qtcursos FROM alunos";
        $sql = $this->pdo->query($sql);

        if($sql->rowCount() > 0) {

            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

        }

        return $array;
    }

    public function excluirAluno($id) {

        $sql = "DELETE FROM alunos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        $sql = "DELETE FROM aluno_curso WHERE id_aluno = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

    }

    public function matricular($nome, $email, $senha) {

        $sql = "INSERT INTO alunos (nome, email, senha) VALUES (:nome, :email, :senha)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

    }

    public function getAluno($id) {
        $array = array();

        $sql = "SELECT * FROM alunos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $array = $sql->fetch(PDO::FETCH_ASSOC);

        }

        return $array;
    }

    public function updateAluno($id, $nome, $email, $senha) {

        $sql = 'UPDATE alunos SET nome = :nome, email = :email, senha = :senha WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    public function resetarCurso($id) {

        $sql = "DELETE FROM aluno_curso WHERE id_aluno = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

    }
}