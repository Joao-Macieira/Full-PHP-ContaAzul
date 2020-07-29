<?php

class Inventory extends model {

    public function getList($offset, $id_company) {
        $array = array();

        $sql = "SELECT * FROM inventory WHERE id_company = :id_company LIMIT $offset, 10";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function add($name, $price, $quant, $min_quant, $id_company, $id_user){

        $sql = "INSERT INTO inventory (id_company, name, price, quant, min_quant) VALUES (:id_company, :name, :price, :quant, :min_quant)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":price", $price);
        $sql->bindValue(":quant", $quant);
        $sql->bindValue(":min_quant", $min_quant);
        $sql->execute();

        $id_product = $this->pdo->lastInsertId();

        $sql = "INSERT INTO inventory_history (id_company, id_product, id_user, action, date_action) VALUES (:id_company, :id_product, :id_user, :action, NOW())";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id_product", $id_product);
        $sql->bindValue(':id_user', $id_user);
        $sql->bindValue(":action", 'add');
        $sql->execute();

    }

}