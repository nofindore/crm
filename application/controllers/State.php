<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : State (StateController)
 * State Class to control all State related operations.
 * @author : Pritesh Khandelwal
 * @version : 1.1
 * @since : 15 August 2018
 */
class State extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('state_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the State
     */
    public function index()
    {
        $searchText = $this->input->post('searchText');
        
        $this->global['searchText'] = $searchText;
        $this->global['pageTitle'] = 'State';
        $this->global['states'] = $this->state_model->getStatesList($searchText);
        
        $this->loadViews("state/index", $this->global, NULL , NULL);
    }
    
    /**
     * This function used to load the State by country
     */
    public function loadByCountry()
    {
        $country_id = $this->input->post('country_id');
        $states = $this->state_model->getStatesListByCountry($country_id);
        
        $data = '';
        if(!empty($states)){
            $data = $data."<option value=''>SELECT STATE</option>";
            foreach($states as $state){
                $data = $data."<option value=".$state->id.">".trim(strtoupper($state->state_name))."</option>";
            }
        } else {
            $data = $data."<option value=''>NO RECORD FOUND</option>";
        }
        echo $data;
    }
}

?>