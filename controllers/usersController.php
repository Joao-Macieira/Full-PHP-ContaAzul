<?php

class usersController extends Controller {

    public function  __construct(){
        $u = new Users();
        if($u->isLogged() == false) {
            header("location: ".BASE_URL.'login');
            exit;
        }
    }

    public function index() {
        $data = array();

        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission("users_view")) {
            $data['users_list'] = $u->getList($u->getCompany());


            $this->loadTemplate('users', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function add() {
        $data = array();

        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission("users_view")) {
                $p = new Permissions();
                $data['group_list'] = $p->getGroupList($u->getCompany());

                if(isset($_POST['email']) && !empty($_POST['email'])) {
                    $email =  filter_input(INPUT_POST, 'email');
                    $pass = filter_input(INPUT_POST, 'password');
                    $group = filter_input(INPUT_POST,'group');

                    $a = $u->add($email, $pass, $group, $u->getCompany());

                    if($a == '1') {
                        header("location: ".BASE_URL.'users');
                    } else {
                        $data['error_msg'] = "Usuário já existe!";
                    }
                }


            $this->loadTemplate('users_add', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function edit($id) {
        $data = array();

        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission("users_view")) {
            $p = new Permissions();
                
            if(isset($_POST['group']) && !empty($_POST['group'])) {
                $pass = filter_input(INPUT_POST, 'password');
                $group = filter_input(INPUT_POST,'group');
                $u->edit($id, $pass, $group, $u->getCompany());

                header("location: ".BASE_URL.'users');
            }
                
            $data['user_info'] = $u->getInfo($id, $u->getCompany());
            $data['group_list'] = $p->getGroupList($u->getCompany());

            $this->loadTemplate('users_edit', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function delete($id) {
        $data = array();

        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission("users_view")) {
            $p = new Permissions();
                
            $u->delete($id, $u->getCompany());
            header("location: ".BASE_URL.'users');
        } else {
            header("location: ".BASE_URL);
        }
    }
}