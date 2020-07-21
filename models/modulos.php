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


}