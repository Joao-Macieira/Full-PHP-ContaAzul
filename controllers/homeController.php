<?php
class homeController extends controller {

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
       
       $this->loadTemplate('home', $data);
    }
}