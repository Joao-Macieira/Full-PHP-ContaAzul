<?php
class purchaseController extends Controller {

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


        if($u->hasPermission('purchase_view')) {
            $p = new Purchase();
            $offset = 0;

            $data['purchase_list'] = $p->getList($offset, $u->getCompany());
            $data['add_permission'] = $u->hasPermission('purchase_add');

            $this->loadTemplate('purchase', $data);
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

        if($u->hasPermission('purchase_add')) {
            $p = new Purchase();

            if(isset($_POST['quant']) && !empty($_POST['quant'])){
                $quant = $_POST['quant'];

                $p->addPurchase($u->getCompany(), $u->getId(), $quant);
            
                header('location: '.BASE_URL.'purchase');
            }
            
            $this->loadTemplate('purchase_add', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function edit($id) {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company =  new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();


        if($u->hasPermission('purchase_view')) {
            $p = new Purchase();

            $data['purchase_info'] = $p->getInfo($id, $u->getCompany());
            
            
            $this->loadTemplate('purchase_edit', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }
}