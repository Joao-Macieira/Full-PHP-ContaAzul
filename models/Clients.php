<?php

class Clients extends Model {


    public function getList($offset, $id_company) {
        $array = array();

        $sql = "SELECT * FROM clients WHERE id_company = :id_company LIMIT $offset, 10";
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

        $sql = "SELECT * FROM clients WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getCount($id_company) {
        $r = 0;

        $sql = "SELECT COUNT(*) as c FROM clients WHERE id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $r = $row['c'];

        return $r;
    }

    public function searchClientByName($name, $id_company) {
        $array = array();

        $sql = "SELECT name, id FROM clients WHERE name LIKE :name AND id_company = :id_company LIMIT 5";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':name', '%'.$name.'%');
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function add($id_company, $name, $email ='', $phone='', $star='3', $internal_obs='', $address_zipcode='', $address='', $address_number='', $address2='', $address_neighb='', $address_city='', $address_state='', $address_country='') {

        $sql = "INSERT INTO clients SET id_company = :id_company, name = :name, email = :email, phone = :phone, stars = :stars, internal_obs = :internal_obs, address_zipcode = :address_zipcode, address = :address, address_number = :address_number, address2 = :address2, address_city = :address_city, address_state = :address_state, address_country = :address_country, address_neighb = :address_neighb";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':phone', $phone);
        $sql->bindValue(':stars', $star);
        $sql->bindValue(':internal_obs', $internal_obs);
        $sql->bindValue(':address_zipcode', $address_zipcode);
        $sql->bindValue(':address', $address);
        $sql->bindValue(':address_number', $address_number);
        $sql->bindValue(':address2', $address2);
        $sql->bindValue(':address_city', $address_city);
        $sql->bindValue(':address_state', $address_state);
        $sql->bindValue(':address_country', $address_country);
        $sql->bindValue(':address_neighb', $address_neighb);
        $sql->execute();

        return $this->pdo->lastInsertId();
    }

    public function edit($id, $id_company, $name, $email, $phone, $star, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country) {
        
        $sql = "UPDATE clients SET id_company = :id_company, name = :name, email = :email, phone = :phone, stars = :stars, internal_obs = :internal_obs, address_zipcode = :address_zipcode, address = :address, address_number = :address_number, address2 = :address2, address_city = :address_city, address_state = :address_state, address_country = :address_country, address_neighb = :address_neighb WHERE id = :id AND id_company = :id_company2";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id_company2', $id_company);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':phone', $phone);
        $sql->bindValue(':stars', $star);
        $sql->bindValue(':internal_obs', $internal_obs);
        $sql->bindValue(':address_zipcode', $address_zipcode);
        $sql->bindValue(':address', $address);
        $sql->bindValue(':address_number', $address_number);
        $sql->bindValue(':address2', $address2);
        $sql->bindValue(':address_city', $address_city);
        $sql->bindValue(':address_state', $address_state);
        $sql->bindValue(':address_country', $address_country);
        $sql->bindValue(':address_neighb', $address_neighb);
        $sql->execute();

    }

}