<?php
class inventoryController extends Controller {

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
        $company =  new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission('inventory_view')) {
            $i = new Inventory();
            $offset = 0;

            $data['inventory_list'] = $i->getList($offset, $u->getCompany());

            $data['add_permission'] = $u->hasPermission('inventory_add');
            $data['edit_permission'] = $u->hasPermission('inventory_edit');
            

            $this->loadTemplate('inventory', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function add() {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company =  new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission('inventory_add')) {

            if(isset($_POST['name']) && !empty($_POST['name'])) {
                $i = new Inventory();

                $name = filter_input(INPUT_POST, 'name');
                $price = filter_input(INPUT_POST, 'price');
                $quant = filter_input(INPUT_POST, 'quant');
                $min_quant = filter_input(INPUT_POST, 'min_quant');
                
                $price = str_replace('.','', $price);
                $price = str_replace(',','.',$price);
                
                $i->add($name, $price, $quant, $min_quant, $u->getCompany(), $u->getId());

                header("location: ".BASE_URL.'inventory');
            }


            $this->loadTemplate('inventory_add',$data);
        }
    }

    public function edit($id) {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company =  new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission('inventory_edit')) {
            $i = new Inventory();

            if(isset($_POST['name']) && !empty($_POST['name'])) {
                

                $name = filter_input(INPUT_POST, 'name');
                $price = filter_input(INPUT_POST, 'price');
                $quant = filter_input(INPUT_POST, 'quant');
                $min_quant = filter_input(INPUT_POST, 'min_quant');
                
                $price = str_replace('.','', $price);
                $price = str_replace(',','.',$price);
                
                $i->edit($id, $name, $price, $quant, $min_quant, $u->getCompany(), $u->getId());

                header("location: ".BASE_URL.'inventory');
            }

            $data['inventory_info'] = $i->getInfo($id, $u->getCompany());

            $this->loadTemplate('inventory_edit',$data);
        }
    }

    public function delete($id) {
        $u = new Users();
        $u->setLoggedUser();

        if($u->hasPermission('inventory_edit')) {
            $i = new Inventory();

            $i->delete($id, $u->getCompany(), $u->getId());

            header('location: '.BASE_URL.'inventory');
        }

    }
}