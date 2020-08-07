<?php

class Inventory extends Model {

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

    public function getInfo($id, $id_company) {
        $array = array();

        $sql = "SELECT * FROM inventory WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount()> 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getInventoryFiltered($id_company) {
        $array = array();

        $sql = "SELECT *, (min_quant-quant) as dif FROM inventory WHERE id_company = :id_company ORDER BY dif DESC";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    private function setLog($id_product, $id_company, $id_user, $action) {
        $sql = "INSERT INTO inventory_history (id_company, id_product, id_user, action, date_action) VALUES (:id_company, :id_product, :id_user, :action, NOW())";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id_product", $id_product);
        $sql->bindValue(':id_user', $id_user);
        $sql->bindValue(":action", $action);
        $sql->execute();
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

        $this->setLog($id_product, $id_company,$id_user, 'add');

    }

    public function edit($id, $name, $price, $quant, $min_quant, $id_company, $id_user){

        $sql = "UPDATE inventory SET name = :name, price = :price, quant = :quant, min_quant = :min_quant WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":price", $price);
        $sql->bindValue(":quant", $quant);
        $sql->bindValue(":min_quant", $min_quant);
        $sql->execute();

        $this->setLog($id, $id_company,$id_user, 'edt');

    }

    public function delete($id, $id_company, $id_user){

        $sql = "DELETE FROM inventory WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        $this->setLog($id, $id_company, $id_user, 'del');

    }

    public function searchProductsByName($name, $id_company) {
        $array = array();

        $sql = 'SELECT name, price, id FROM inventory WHERE id_company = :id_company AND name LIKE :name LIMIT 10';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":name", '%'.$name.'%');
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function decrease($id_prod, $id_company, $quant_prod, $id_user) {
        $sql = "UPDATE inventory SET quant = quant - $quant_prod WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue("id", $id_prod);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        $this->setLog($id_prod, $id_company, $id_user, 'dwn');

    }

    public function addInventory($id_prod, $id_company, $quant_prod, $id_user){
        $sql = "UPDATE inventory SET quant = quant + $quant_prod WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue("id", $id_prod);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        $this->setLog($id_prod, $id_company, $id_user, 'upi');
    }
}