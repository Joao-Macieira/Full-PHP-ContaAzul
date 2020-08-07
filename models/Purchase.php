<?php

class Purchase extends Model {

    public function getList($offset, $id_company) {
        $array = array();

        $sql = "SELECT purchases.id, purchases.date_purchase, purchases.total_price, users.email FROM purchases LEFT JOIN users ON users.id = purchases.id_user WHERE purchases.id_company = :id_company ORDER BY purchases.date_purchase DESC LIMIT $offset, 10";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getInfo($id_purchase, $id_company) {
        $array = array();

        $sql = 'SELECT * FROM purchases WHERE id = :id AND id_company = :id_company';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id_purchase);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array['info'] = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $sql = 'SELECT * FROM purchases_products WHERE id_purchase = :id_purchase AND id_company = :id_company';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_purchase", $id_purchase);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0 ){
            $array['products'] = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getPurchasesFiltered($id_company) {
        $array = array();

        $sql = "SELECT purchases.id, purchases.date_purchase, purchases.total_price, users.email FROM purchases LEFT JOIN users ON users.id = purchases.id_user WHERE purchases.id_company = :id_company ORDER BY purchases.date_purchase DESC";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function addPurchase($id_company, $id_user, $quant) {
        $i = new Inventory();

        $sql = "INSERT INTO purchases (id_company, id_user, total_price, date_purchase) VALUES (:id_company, :id_user, :total_price, NOW())";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id_user", $id_user);
        $sql->bindValue(":total_price", '0');
        $sql->execute();

        $id_purchase = $this->pdo->lastInsertId();

        $purchase_price = 0;

        foreach($quant as $id_prod => $quant_prod) {

            $sql = "SELECT price, name FROM inventory WHERE id  = :id AND id_company = :id_company";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id", $id_prod);
            $sql->bindValue(":id_company", $id_company);
            $sql->execute();


            if($sql->rowCount() > 0) {
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $price = $row['price'];
                $name = $row['name'];

                $sqlp = "INSERT INTO purchases_products (id_company, id_purchase, name, quant, purchase_price) VALUES (:id_company, :id_purchase, :name, :quant, :purchase_price)";
                $sqlp = $this->pdo->prepare($sqlp);
                $sqlp->bindValue(':id_company', $id_company);
                $sqlp->bindValue(":id_purchase", $id_purchase);
                $sqlp->bindValue(':name', $name);
                $sqlp->bindValue(':quant', $quant_prod);
                $sqlp->bindValue(':purchase_price', $price);
                $sqlp->execute();

                $i->addInventory($id_prod, $id_company, $quant_prod, $id_user);

                $purchase_price += $price*$quant_prod;
            }

        }

        $sql = "UPDATE purchases SET total_price = :total_price WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id_purchase);
        $sql->bindValue(':total_price', $purchase_price);
        $sql->execute();

    }

    public function getTotalExpenses($period1, $period2, $id_company) {
        $float = 0;

        $sql = "SELECT SUM(total_price) as total FROM purchases WHERE id_company = :id_company AND date_purchase BETWEEN :period1 AND :period2";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":period1", $period1);
        $sql->bindValue(":period2", $period2);
        $sql->execute();

        $n = $sql->fetch(PDO::FETCH_ASSOC);
        $float = $n['total'];

        return $float;
    }

    public function getExpensesList($period1, $period2, $id_company) {
        $array = array();
        $currentDay = $period1;

        while($period2 != $currentDay) {
            $array[$currentDay] = 0;
            $currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
        }

        $sql = "SELECT DATE_FORMAT(date_purchase, '%Y-%m-%d') as date_purchase, SUM(total_price) as total FROM purchases WHERE id_company = :id_company AND date_purchase BETWEEN :period1 AND :period2 GROUP BY DATE_FORMAT(date_purchase, '%Y-%m-%d')";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":period1", $period1);
        $sql->bindValue(":period2", $period2);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $sale_item) {
                $array[$sale_item['date_purchase']] = $sale_item['total'];
            }
        }

        return $array;
    }
}