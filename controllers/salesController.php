<?php
class salesController extends Controller {

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

        $data['statuses'] = array(
            '1' =>'Aguardando Pagamento',
            '2' =>'Pago',
            '3' => 'Cancelado'
        );

        if($u->hasPermission('sales_view')) {
            $s = new Sales();
            $offset = 0;

            $data['sales_list'] = $s->getList($offset, $u->getCompany());

            $this->loadTemplate('sales', $data);
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

        if($u->hasPermission('sales_view')) {
            $s = new Sales();

            if(isset($_POST['client_id']) && !empty($_POST['client_id'])){
                $client_id = filter_input(INPUT_POST,'client_id');
                $status = filter_input(INPUT_POST,'status');
                $quant = $_POST['quant'];

                $s->addSale($u->getCompany(), $client_id, $u->getId(), $quant, $status);
            
                header('location: '.BASE_URL.'sales');
            }
            
            $this->loadTemplate('sales_add', $data);
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

        $data['statuses'] = array(
            '1' =>'Aguardando Pagamento',
            '2' =>'Pago',
            '3' => 'Cancelado'
        );

        if($u->hasPermission('sales_view')) {
            $s = new Sales();

            $data['permission_edit'] = $u->hasPermission('sales_edit');

            if(isset($_POST['status']) && !empty($_POST['status']) && $data['permission_edit']){
                $status = filter_input(INPUT_POST,'status');

                $s->changeStatus($status, $id, $u->getCompany());
            
                header('location: '.BASE_URL.'sales');
            }

            $data['sales_info'] = $s->getInfo($id, $u->getCompany());
            
            
            $this->loadTemplate('sales_edit', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }
}