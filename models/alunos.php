<?php

class Alunos extends model {

    public function isLogged() {
        
		if(isset($_SESSION['lgaluno']) && !empty($_SESSION['lgaluno'])) {
            return true;
		} else {
			return false;
		}
	}

    public function fazerLogin($email, $senha) {

        $sql = "SELECT * FROM alunos WHERE email = :email AND senha = :senha";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        if($sql->rowCount() > 0) {
			$row = $sql->fetch();

      $_SESSION['lgaluno'] = $row['id'];
      
			return true;
		}

		return false;

    }

}