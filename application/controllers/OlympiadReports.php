<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : (OlympiadReports)
 * OlympiadReports Class to control all olympiad reports related operations for nof.
 * @author : PK
 * @version : 1.1
 * @since : 23 Septemeber 2018
 */
class OlympiadReports extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
    }
    
    /**
     * This function is used to load the school list
     */
    function index()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Olympiad Reports';
            
            $this->loadViews("olympiad/reports/index", $this->global, NULL , NULL);
        }
    }
}
?>
