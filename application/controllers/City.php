<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : City (CityController)
 * City Class to control all City related operations.
 * @author : Pritesh Khandelwal
 * @version : 1.1
 * @since : 15 August 2018
 */
class City extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('city_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the City
     */
    public function index()
    {
        $searchText = $this->input->post('searchText');
        
        $this->global['searchText'] = $searchText;
        $this->global['pageTitle'] = 'City';
        $this->global['cities'] = $this->city_model->getCitiesList($searchText);
        
        $this->loadViews("city/index", $this->global, NULL , NULL);
    }
    
    /**
     * This function used to load the city by State
     */
    public function loadByState()
    {
        $state_id = $this->input->post('state_id');
        $cities = $this->city_model->getCitiesListByState($state_id);
        
        $data = '';
        if(!empty($cities)){
            $data = $data."<option value=''>SELECT CITY</option>";
            foreach($cities as $city){
                $data = $data."<option value=".$city->id.">".trim(strtoupper($city->city_name))."</option>";
            }
        } else {
            $data = $data."<option value=''>NO RECORD FOUND</option>";
        }
        echo $data;
    }
}

?>