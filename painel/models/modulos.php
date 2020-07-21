<?php

class Modulos extends model {

    public function getModulos($id_curso) {
        $array = array();

        $sql = "SELECT * FROM modulos WHERE id_curso = :id_curso";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_curso", $id_curso);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

            $aulas = new Aulas();

            foreach($array as $mChave => $mDados) {

                $array[$mChave]['aulas'] = $aulas->getAulasDeModulo($mDados['id']);

            }

        }
        return $array;
    }
    
    public function getCurso($id) {

        $array = array();

        $sql = "SELECT id_curso FROM modulos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $array = $sql->fetch(PDO::FETCH_ASSOC);   

        }

        return $array;
    }

    public function addModulo($id, $modulo) {

        $sql = "INSERT INTO modulos (id_curso, nome) VALUES (:id, :modulo)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":modulo", $modulo);
        $sql->execute();

    }

    public function deleteModulo($id) {

        $sql = "DELETE FROM modulos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    public function getModulo($id) {
        $array = array();

        $sql = "SELECT * FROM modulos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function updateModulo($id, $nome) {

        $sql = "UPDATE modulos SET nome = :nome WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":nome", $nome);
        $sql->execute();

    }

}