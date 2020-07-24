<?php

class Permissions extends model {

    private $group;
    private $permissions;

    public function setGroup($id, $id_company) {
        $this->group = $id;
        $this->permissions = array();

        $sql = "SELECT params FROM permission_groups WHERE id = :id AND id_company = :id_company";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql -> rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            if(empty($row['params'])) {
                $row['params'] = '0';
            }
            
            $params = $row['params'];

            $sql = "SELECT name FROM permission_params WHERE id IN ($params) AND id_company = :id_company";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_company", $id_company);
            $sql->execute();

            if($sql -> rowCount() > 0) {
                foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $item) {
                    $this->permissions[] = $item['name'];
                }
            }
        }
    }

    public function hasPermission($name) {
        if(in_array($name, $this->permissions)){
            return true;
        } else {
            return false;
        }
    }

}