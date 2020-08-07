<?php
class homeController extends Controller {

    public function __construct(){
      
        $u = new Users();

        if($u->isLogged() == false) {
            header("location: ".BASE_URL.'login');
        }

    }

    public function index(){
       $data = array();

        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        $s = new Sales();
        $p = new Purchase();

        $data['statuses'] = array(
            '1' =>'Aguardando Pagamento',
            '2' =>'Pago',
            '3' => 'Cancelado'
        );

        $data['products_sold'] = $s->getSoldProducts(date('Y-m-d', strtotime('-30 days')), date('Y-m-d', strtotime('+1 day')), $u->getCompany());
        $data['revenue'] = $s->getTotalRevenue(date('Y-m-d', strtotime('-30 days')), date('Y-m-d', strtotime('+1 day')), $u->getCompany());
        $data['expenses'] = $p->getTotalExpenses(date('Y-m-d', strtotime('-1 month')), date('Y-m-d', strtotime('+1 day')), $u->getCompany());
       

        $data['days_list'] = array();
        for($q = 30; $q>=0; $q--) {
            $data['days_list'][] = date('d/m', strtotime('-'.$q.' days'));
        }

        $data['revenue_list'] = $s->getRevenueList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d', strtotime('+1 day')), $u->getCompany());
        $data['expenses_list'] = $p->getExpensesList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d', strtotime('+1 day')), $u->getCompany());
        $data['status_list'] = $s->getQuantStatusList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d', strtotime('+1 day')), $u->getCompany());

       $this->loadTemplate('home', $data);
    }
}