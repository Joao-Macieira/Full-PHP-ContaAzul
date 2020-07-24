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
                $this->permissions->setGroup($this->userInfo['group'], $this->userInfo['id_company']);
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

}