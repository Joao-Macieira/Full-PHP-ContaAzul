<?php

class Users extends model {

    private $userInfo;
    private $permissions;

    public function isLogged() {

        if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
            return true;
        } else {
            return  false;
        }

    }

    public function doLogin($email, $pass) {
        
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $sql = $this->pdo->prepare($sql);
        $sql -> bindValue(":email", $email);
        $sql -> bindValue(":password", md5($pass));
        $sql -> execute();

        if ($sql -> rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            $_SESSION['ccUser'] = $row['id'];
            return true;
        } else {
            return false;
        }
    }

    public function setLoggedUser() {

        if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
        
            $id = $_SESSION['ccUser'];

            $sql = "SELECT * FROM users WHERE id = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $this->userInfo = $sql ->fetch(PDO::FETCH_ASSOC);
                $this->permissions = new Permissions();
                $this->permissions->setGroup($this->userInfo['id_group'], $this->userInfo['id_company']);
            }
        }    
    }

    public function logout() {
        unset($_SESSION['ccUser']);
    }

    public function hasPermission($name) {
        return $this->permissions->hasPermission($name);
    }

    public function getCompany() {
        if (isset($this->userInfo['id_company'])) {
            return $this->userInfo['id_company'];
        } else {
            return 0;
        }
    }

    public function getEmail() {
        if (isset($this->userInfo['email'])) {
            return $this->userInfo['email'];
        } else {
            return 0;
        }
    }

    public function getInfo($id, $id_company) {
        $array = array();

        $sql = "SELECT * FROM users WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function findUsersInGroup($id) {

        $sql = "SELECT COUNT(*) as c FROM users WHERE id_group = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        $row = $sql->fetch(PDO::FETCH_ASSOC);

        if($row['c'] == '0') {
            return false;
        } else {
            return true;
        }
    }

    public function getList($id_company) {
        $array = array();

        $sql = "SELECT users.id, users.email, permission_groups.name FROM users LEFT JOIN permission_groups ON permission_groups.id = users.id_group WHERE users.id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function add($email, $pass, $group, $id_company) {

        $sql = "SELECT COUNT(*) as c FROM users WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        $row = $sql->fetch(PDO::FETCH_ASSOC);
        if($row['c'] == '0') {
            $sql = "INSERT INTO users (id_company, email, password, id_group) VALUES (:id_company, :email, :pass, :id_group)";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_company", $id_company);
            $sql->bindValue(":email", $email);
            $sql->bindValue(':pass', md5($pass));
            $sql->bindValue(":id_group", $group);
            $sql->execute();

            return '1';
        } else {
            return '0';
        }
    }

    public function edit($id, $pass, $group, $id_company) {
        
        $sql = "UPDATE users SET id_group = :id_group WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id_group', $group);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if(!empty($pass)) {
            $sql = "UPDATE users SET password = :pass WHERE id = :id AND id_company = :id_company";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':pass', md5($pass));
            $sql->bindValue(':id', $id);
            $sql->bindValue(':id_company', $id_company);
            $sql->execute();
        }
    }

    public function delete($id, $id_company) {

        $sql = "DELETE FROM users WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();
    }

}