<?php 

class ajaxController extends controller {

    public function  __construct(){
        $u = new Users();
        if($u->isLogged() == false) {
            header("location: ".BASE_URL.'login');
            exit;
        }
    }

    public function index() {}

    public function search_clients() {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $c = new Clients();

        if(isset($_GET['q']) && !empty($_GET['q'])) {
            $q = filter_input(INPUT_GET, 'q');

            $clients = $c->searchClientByName($q, $u->getCompany());
        
            foreach($clients as $citem) {
                $data[] = array(
                    'name' => $citem['name'],
                    'link' => BASE_URL.'clients/edit/'.$citem['id']
                );
            }
        }

        echo json_encode($data);
    }
}