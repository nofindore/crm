<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model
{
    function getCitiesList($searchText = '')
    {
        $nof = $this->load->database('nof', TRUE); 
        $nof->select('city.id AS id, city.city_name AS city_name, state.State AS state_name');
        $nof->from('city as city');
        $nof->join('state as state', 'state.State_id = city.state_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(country.country_name  LIKE '%".$searchText."%')";
            $nof->where($likeCriteria);
        }
        $nof->order_by('city.city_name ASC');
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }

    function getCitiesListByState($state_id)
    {
        $nof = $this->load->database('nof', TRUE); 
        $nof->select('city.id AS id, city.city_name AS city_name, state.State AS state_name');
        $nof->from('city as city');
        $nof->join('state as state', 'state.State_id = city.state_id','left');
        if(!empty($state_id)) {
            $likeCriteria = "(city.state_id = ".$state_id.")";
            $nof->where($likeCriteria);
        }
        $nof->order_by('city.city_name ASC');
        $query = $nof->get();

        $result = $query->result();

        return $result;
    }
}

?>
