<?php

class Aulas extends model {

    public function marcarAssistido($id) {
        $aluno = $_SESSION['lgaluno'];

        $sql = "INSERT INTO historico (data_viewed, id_aluno, id_aula) VALUES (NOW(), :aluno, :id)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":aluno", $aluno);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function getAulasDeModulo($id) {
        $array = array();

        $sql = "SELECT * FROM aulas WHERE id_modulo = :id ORDER BY ordem";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($array as $aulaChave => $aula) {

                if($aula['tipo'] == 'video') {
                    $sql = "SELECT nome FROM videos WHERE id_aula = :id";
                    $sql = $this->pdo->prepare($sql);
                    $sql->bindValue(":id", $aula['id']);
                    $sql->execute();
                        #taulas -> todas as aulas
                    $taulas = $sql->fetch(PDO::FETCH_ASSOC);

                    $array[$aulaChave]['nome'] = $taulas['nome'];
                
                } elseif($aula['tipo'] == 'poll') {
                    $array[$aulaChave]['nome'] = 'Questionário';
                
                }

            }
        }

        return $array;
    }

    public function getCursoDeAula($id_aula) {

        $sql = "SELECT id_curso FROM aulas WHERE id=:id_aula";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();

        if($sql->rowcount() > 0) {

            $row = $sql->fetch();

            return $row['id_curso'];
        } else {
            return 0;
        }

    }

    public function getAula($id_aula) {
        $array = array();

        $id_aluno = $_SESSION['lgaluno'];

        $sql = "SELECT tipo,(select count(*) from historico where historico.id_aula = :hidaula and historico.id_aluno = :hidaluno) as assistido FROM aulas WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":hidaula", $id_aula);
        $sql->bindValue(":hidaluno", $id_aluno);
        $sql->bindValue(':id', $id_aula);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $row = $sql->fetch(PDO::FETCH_ASSOC);
            

            if($row['tipo'] == 'video') {

                $sql = "SELECT * FROM videos WHERE id_aula = :id";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":id", $id_aula);
                $sql->execute();

                $array = $sql->fetch(PDO::FETCH_ASSOC);

                $array['tipo'] = 'video';

            } elseif($row['tipo'] == 'poll') {

                $sql = "SELECT * FROM questionarios WHERE id_aula = :id";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":id", $id_aula);
                $sql->execute();

                $array = $sql->fetch(PDO::FETCH_ASSOC);

                $array['tipo'] = 'poll';

            }
            $array['assistido'] = $row['assistido'];
        }


        return $array;
    }

    public function setDuvida($duvida, $aluno) {

        $sql = "INSERT INTO duvidas (data_duvida, duvida, id_aluno) VALUES (NOW(), :duvida, :id)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":duvida", $duvida);
        $sql->bindValue(":id", $aluno);
        $sql->execute();
    }

}