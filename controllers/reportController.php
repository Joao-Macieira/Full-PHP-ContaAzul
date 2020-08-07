<?php
class reportController extends Controller {

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

        if($u->hasPermission('report_view')) {
           

            $this->loadTemplate('report', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function sales() {
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

        if($u->hasPermission('report_view')) {
            

            $this->loadTemplate('report_sales', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function sales_pdf(){
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

        if($u->hasPermission('report_view')) {
            $client_name = filter_input(INPUT_GET, 'client_name');
            $period1 = filter_input(INPUT_GET, 'period1');
            $period2 = filter_input(INPUT_GET, 'period2');
            $status = filter_input(INPUT_GET, 'status');
            $order = filter_input(INPUT_GET, 'order');

            $s = new Sales();
            $data['sales_list'] = $s->getSalesFiltered($client_name, $period1, $period2, $status, $order, $u->getCompany());

            $data['filters'] = $_GET;

            $this->loadLibrary('autoload');

            ob_start();
            $this->loadView('report_sales_pdf', $data);
            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            header("location: ".BASE_URL);
        }
    }
    

    public function inventory() {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company =  new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();


        if($u->hasPermission('report_view')) {
            

            $this->loadTemplate('report_inventory', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function inventory_pdf() {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company =  new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();



        if($u->hasPermission('report_view')) {
            $i = new Inventory();
            $data['inventory_list'] = $i->getInventoryFiltered($u->getCompany());

            $data['filters'] = $_GET;

            $this->loadLibrary('autoload');

            ob_start();
            $this->loadView('report_inventory_pdf', $data);
            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function purchases() {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company =  new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();


        if($u->hasPermission('report_view')) {
            

            $this->loadTemplate('report_purchases', $data);
        } else {
            header("location: ".BASE_URL);
        }
    }

    public function purchases_pdf(){
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company =  new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();



        if($u->hasPermission('report_view')) {
            $p = new Purchase();
            $data['purchases_list'] = $p->getPurchasesFiltered($u->getCompany());

            $data['filters'] = $_GET;

            $this->loadLibrary('autoload');

            ob_start();
            $this->loadView('report_purchase_pdf', $data);
            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            header("location: ".BASE_URL);
        }
    }
}