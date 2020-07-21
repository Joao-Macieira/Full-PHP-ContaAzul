<?php

class Aulas extends model {

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

        $sql = "SELECT tipo FROM aulas WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
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
        }


        return $array;
    }


    public function getCurso($id) {

        $array = array();

        $sql = "SELECT id_curso FROM aulas WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $array = $sql->fetch(PDO::FETCH_ASSOC);   

        }

        return $array;
    }

    public function deleteAula($id) {

        $sql = "DELETE FROM aulas WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = "DELETE FROM questionarios WHERE id_aula = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = "DELETE FROM videos WHERE id_aula = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = "DELETE FROM historico WHERE id_aula = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    public function addAula($id_curso, $id_modulo, $nome, $tipo) {
        $ordem = 1;
        $sql = "SELECT ordem FROM aulas WHERE id_modulo = :id_modulo ORDER BY ordem DESC LIMIT 1";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch(PDO::FETCH_ASSOC);

            $ordem = intval($sql['ordem']);
            $ordem++;

        }

        $sql = "INSERT INTO aulas (id_modulo, id_curso, ordem, tipo) VALUES (:id_modulo, :id_curso, :ordem, :tipo)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->bindValue(":id_curso", $id_curso);
        $sql->bindValue(":ordem", $ordem);
        $sql->bindValue(":tipo", $tipo);
        $sql->execute();

        $id_aula = $this->pdo->lastInsertId();

        if($tipo == 'video') {
            $sql = "INSERT INTO videos (id_aula, nome) VALUES (:id_aula, :nome)";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_aula", $id_aula);
            $sql->bindValue(":nome", $nome);
            $sql->execute();
        } else {
            $sql = "INSERT INTO questionarios SET id_aula=:id_aula";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_aula", $id_aula);
            $sql->execute();
        }

    }

    public function updateVideoAula($id, $nome, $descricao, $url) {

        $sql = "UPDATE videos SET nome = :nome, descricao = :descricao, url = :url WHERE id_aula = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':url', $url);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function updateQuestionarioAula($id, $pergunta, $opcao1, $opcao2, $opcao3, $opcao4, $opcao5, $resposta) {

        $sql = "UPDATE questionarios SET pergunta = :pergunta, opcao1 = :opcao1, opcao2 = :opcao2, opcao3 = :opcao3, opcao4 = :opcao4, opcao5 = :opcao5, resposta = :resposta WHERE id_aula = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":pergunta", $pergunta);
        $sql->bindValue(":opcao1", $opcao1);
        $sql->bindValue(":opcao2", $opcao2);
        $sql->bindValue(":opcao3", $opcao3);
        $sql->bindValue(":opcao4", $opcao4);
        $sql->bindValue(":opcao5", $opcao5);
        $sql->bindValue(":resposta", $resposta);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}