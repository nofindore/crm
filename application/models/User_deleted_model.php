<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_deleted_model extends CI_Model
{   
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewEntry($userInfo)
    {
        $nof = $this->load->database('nof', TRUE);
        $nof->trans_start();
        $nof->insert('user_deleted', $userInfo);
        
        $insert_id = $nof->insert_id();
        
        $nof->trans_complete();
        
        return $insert_id;
    }
}

  