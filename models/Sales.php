<?php

class Sales extends Model {

    public function getList($offset, $id_company) {
        $array = array();

        $sql = "SELECT sales.id, sales.date_sale, sales.total_price, sales.status, clients.name FROM sales LEFT JOIN clients ON clients.id = sales.id_client WHERE sales.id_company = :id_company ORDER BY sales.date_sale DESC LIMIT $offset, 10";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getInfo($id, $id_company) {
        $array = array();

        $sql = "SELECT *, (select clients.name from clients where clients.id = sales.id_client) as client_name FROM sales WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0 ){
            $array['info'] = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $sql = 'SELECT sales_products.quant, sales_products.sale_price, inventory.name FROM sales_products LEFT JOIN inventory ON inventory.id = sales_products.id_product WHERE sales_products.id_sale = :id_sale AND sales_products.id_company = :id_company';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_sale", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0 ){
            $array['products'] = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function addSale($id_company, $id_client, $id_user, $quant, $status) {
        $i = new Inventory();

        $sql = "INSERT INTO sales (id_company, id_client, id_user, total_price, status, date_sale) VALUES (:id_company, :id_client, :id_user, :total_price, :status, NOW())";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id_client", $id_client);
        $sql->bindValue(":id_user", $id_user);
        $sql->bindValue(":total_price", '0');
        $sql->bindValue(":status", $status);
        $sql->execute();

        $id_sale = $this->pdo->lastInsertId();

        $total_price = 0;

        foreach($quant as $id_prod => $quant_prod) {

            $sql = "SELECT price FROM inventory WHERE id  = :id AND id_company = :id_company";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id", $id_prod);
            $sql->bindValue(":id_company", $id_company);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $price = $row['price'];

                $sqlp = "INSERT INTO sales_products (id_company, id_sale, id_product, quant, sale_price) VALUES (:id_company, :id_sale, :id_product, :quant, :sale_price)";
                $sqlp = $this->pdo->prepare($sqlp);
                $sqlp->bindValue(':id_company', $id_company);
                $sqlp->bindValue(':id_sale', $id_sale);
                $sqlp->bindValue(':id_product', $id_prod);
                $sqlp->bindValue(':quant', $quant_prod);
                $sqlp->bindValue(':sale_price', $price);
                $sqlp->execute();

                $i->decrease($id_prod, $id_company, $quant_prod, $id_user);

                $total_price += $price*$quant_prod;
            }

        }

        $sql = "UPDATE sales SET total_price = :total_price WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id_sale);
        $sql->bindValue(':total_price', $total_price);
        $sql->execute();

    }

    public function changeStatus($status, $id, $id_company) {

        $sql = "UPDATE sales SET status = :status WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":status", $status);
        $sql->bindValue(":id", $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

    }


    public function getSalesFiltered($client_name, $period1, $period2, $status, $order, $id_company){
        $array = array();

        $sql = "SELECT clients.name, sales.date_sale, sales.total_price, sales.status FROM sales LEFT JOIN clients ON clients.id = sales.id_client WHERE ";

        $where = array();
        $where[] = "sales.id_company = :id_company";

        if(!empty($client_name)) {
            $where[]  = 'clients.name LIKE :client_name';
        }

        if(!empty($period1) && !empty($period2)) {
            $where[] = "sales.date_sale BETWEEN :period1 AND :period2";
        }

        if($status != '') {
            $where[] = 'sales.status = :status';
        }

        $sql .= implode(' AND ', $where);
        
        switch($order) {
            case 'date_desc':
                default:
                $sql .= ' ORDER BY sales.date_sale DESC';
            break;
            case 'date_asc':
                $sql .= ' ORDER BY sales.date_sale ASC';
            break;
            case 'status':
                $sql .= ' ORDER BY sales.status';
            break;
        }

        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        if(!empty($client_name)) {
            $sql->bindValue(":client_name", '%'.$client_name.'%');
        }

        if(!empty($period1) && !empty($period2)) {
            $sql->bindValue(":period1", $period1);
            $sql->bindValue(":period2", $period2);
        }

        if($status != '') {
            $sql->bindValue(":status", $status);
        }

        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getTotalRevenue($period1, $period2, $id_company) {
        $float = 0;

        $sql = "SELECT SUM(total_price) as total FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":period1", $period1);
        $sql->bindValue(":period2", $period2);
        $sql->execute();

        $n = $sql->fetch(PDO::FETCH_ASSOC);
        $float = $n['total'];

        return $float;
    }

    public function getSoldProducts($period1, $period2, $id_company) {
        $int = 0;

        $sql = "SELECT id FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":period1", $period1);
        $sql->bindValue(":period2", $period2);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $p = array();
            foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $sale_item){
                $p[] = $sale_item['id'];
            }

            $sql = "SELECT COUNT(*) as total FROM sales_products WHERE id_sale IN (".implode(',', $p).")";
            $sql = $this->pdo->query($sql);

            $n = $sql->fetch(PDO::FETCH_ASSOC);
            $int = $n['total'];

        }

        return $int;
    }

    public function getRevenueList($period1, $period2, $id_company) {
        $array = array();
        $currentDay = $period1;

        while($period2 != $currentDay) {
            $array[$currentDay] = 0;
            $currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
        }

        $sql = "SELECT DATE_FORMAT(date_sale, '%Y-%m-%d') as date_sale, SUM(total_price) as total FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2 GROUP BY DATE_FORMAT(date_sale, '%Y-%m-%d')";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":period1", $period1);
        $sql->bindValue(":period2", $period2);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $sale_item) {
                $array[$sale_item['date_sale']] = $sale_item['total'];
            }
        }

        return $array;
    }

    public function getQuantStatusList($period1, $period2, $id_company) {
        $array = array('1'=>0, '2'=>0,'3'=>0);

        $sql = "SELECT COUNT(id) as total, status FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2 GROUP BY status ORDER BY status ASC";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":period1", $period1);
        $sql->bindValue(":period2", $period2);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $sale_item) {
                $array[$sale_item['status']] = $sale_item['total'];
            }
        }

        return $array;
    }
}