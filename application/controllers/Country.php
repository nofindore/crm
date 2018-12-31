<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Country extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('country_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $searchText = $this->input->post('searchText');
        
        $this->global['searchText'] = $searchText;
        $this->global['pageTitle'] = 'Country';
        $this->global['countries'] = $this->country_model->getCountryList($searchText);
        
        $this->loadViews("country/index", $this->global, NULL , NULL);
    }
}

?>