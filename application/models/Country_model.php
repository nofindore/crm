<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Country_model extends CI_Model
{
    function getCountryList($searchText = '')
    {
        $nof = $this->load->database('nof', TRUE); 
        $nof->select('country.id AS id, country.country_name');
        $nof->from('country as country');
        if(!empty($searchText)) {
            $likeCriteria = "(country.country_name  LIKE '%".$searchText."%')";
            $nof->where($likeCriteria);
        }
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }
}

?>
