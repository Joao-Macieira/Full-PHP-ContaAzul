<?php

class clientsController extends controller {

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

        if($u->hasPermission("clients_view")) {
            $c = new Clients();
            $offset = 0;
            $data['clients_list'] = $c->getList($offset);
            $data['edit_permission'] = $u->hasPermission("clients_edit");

            $this->loadTemplate('clients', $data);
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

        if($u->hasPermission("clients_edit")) {
            $c = new Clients();
            
            if(isset($_POST['name']) && !empty($_POST['name'])) {
                $name = filter_input(INPUT_POST, 'name');
                $email = filter_input(INPUT_POST, 'email');
                $phone = filter_input(INPUT_POST, 'phone');
                $star = filter_input(INPUT_POST, 'stars');
                $internal_obs = filter_input(INPUT_POST, 'internal_obs');
                $address_zipcode = filter_input(INPUT_POST, 'address_zipcode');
                $address = filter_input(INPUT_POST, 'address');
                $address_number = filter_input(INPUT_POST, 'address_number');
                $address2 = filter_input(INPUT_POST, 'address2');
                $address_neighb = filter_input(INPUT_POST, 'address_neighb');
                $address_city = filter_input(INPUT_POST, 'address_city');
                $address_state = filter_input(INPUT_POST, 'address_state');
                $address_country = filter_input(INPUT_POST, 'address_country');

                $c->add($u->getCompany(), $name, $email, $phone, $star, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country);


                header('location: '.BASE_URL.'clients');
            }

            $this->loadTemplate('clients_add', $data);
        } else {
            header("location: ".BASE_URL.'clients');
        }
    }
}