<?php

class Alunos extends model {

    private $info;

    public function isLogged() {
      
      if(isset($_SESSION['lgaluno']) && !empty($_SESSION['lgaluno'])) {
        return true;
      } else {
        return false;
      }
	}

    public function fazerLogin($email, $senha) {

        $sql = "SELECT * FROM alunos WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);
      
            if(password_verify($senha, $row['senha'])) {
                $_SESSION['lgaluno'] = $row['id'];
			    return true;
            }
		}

		return false;

    }

    public function isInscrito($id_curso) {

        $sql = "SELECT * FROM aluno_curso WHERE id_aluno = :id_aluno AND id_curso = :id_curso";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_aluno", $this->info['id']);
        $sql->bindValue(':id_curso', $id_curso);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function setAluno($id) {
        $sql = "SELECT * FROM alunos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $this->info = $sql->fetch(PDO::FETCH_ASSOC);

        }
    }

    public function getNome() {
        return $this->info['nome'];
    }

    public function getId(){
        return $this->info['id'];
    }

    public function getNumAulasAssistidas($id_curso) {

        $sql = "SELECT id FROM historico WHERE id_aluno = :id_aluno AND id_aula IN (select aulas.id from aulas where aulas.id_curso = :id_curso)";
        $sql = $this->pdo->prepare($sql);
        $sql -> bindValue(":id_aluno", $this->getId());
        $sql -> bindValue(":id_curso", $id_curso);
        $sql -> execute();

        return $sql->rowCount();
    }

}