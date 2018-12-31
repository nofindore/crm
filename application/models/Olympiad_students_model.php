<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Olympiad_students_model extends CI_Model
{
    /**
     * This function is used to get the olympiad schools listing
     * @return array $result : This is schools list
     */
    function getList()
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

        $nof->select('olympiad_student.*, olympiad_school.name as school_name');

        $nof->from('olympiad_student as olympiad_student');

        $nof->join('olympiad_school as olympiad_school', 'olympiad_school.id = olympiad_student.school','left');
        
        $nof->order_by('olympiad_student.roll_number', 'ASC');

        $nof->order_by('olympiad_student.class', 'ASC');

        $query = $nof->get();

        $result = $query->result_array();

        return $result;
    }

    /**
     * This function is used to get the olympiad schools listing
     * @return array $result : This is schools list
     */
    function getListBySchool($id)
    {
        $nof = $this->load->database('nof', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

        $nof->select('olympiad_student.*, olympiad_school.name as school_name, city.city_name as city_name, state.State as state_name');

        $nof->from('olympiad_student as olympiad_student');

        $nof->join('olympiad_school as olympiad_school', 'olympiad_school.id = olympiad_student.school','left');

        $nof->join('city as city', 'city.id = olympiad_school.city','left');

        $nof->join('state as state', 'state.State_id = olympiad_school.state','left');

        $nof->where('olympiad_student.school', $id);
        
        $nof->order_by('olympiad_student.roll_number', 'ASC');

        $nof->order_by('olympiad_student.class', 'ASC');

        $query = $nof->get();

        $result = $query->result_array();

        return $result;
    }

    /**
     * This function is used to get the olympiad papers and books record
     * @return array $result : This is papers and book details
     */
    function getAllPapersAndBooks()
    {
        $nof = $this->load->database('nof', TRUE);

        $nof->select('olympiad_student.class, SUM(if(science_paper = 1, 1, 0)) AS science_paper, SUM(if(science_book = 1, 1, 0)) AS science_book, SUM(if(math_paper = 1, 1, 0)) AS math_paper, SUM(if(math_book = 1, 1, 0)) AS math_book, SUM(if(english_paper = 1, 1, 0)) AS english_paper, SUM(if(english_book = 1, 1, 0)) AS english_book, SUM(if(gk_paper = 1, 1, 0)) AS gk_paper, SUM(if(gk_book = 1, 1, 0)) AS gk_book, SUM(if(commerce_paper = 1, 1, 0)) AS commerce_paper, SUM(if(commerce_book = 1, 1, 0)) AS commerce_book, SUM(if(bio_paper = 1, 1, 0)) AS bio_paper, SUM(if(bio_book = 1, 1, 0)) AS bio_book');

        $nof->from('olympiad_student as olympiad_student');
        
        $nof->group_by('olympiad_student.class', 'ASC');

        $nof->order_by('olympiad_student.class', 'ASC');

        $query = $nof->get();

        $result = $query->result_array();

        return $result;
    }

    /**
     * This function is used to get the olympiad papers and books record
     * @return array $result : This is papers and book details
     */
    function getSchoolsPapersAndBooks()
    {
        $nof = $this->load->database('nof', TRUE);

        $nof->select('olympiad_student.class, olympiad_student.school, SUM(if(science_paper = 1, 1, 0)) AS science_paper, SUM(if(science_book = 1, 1, 0)) AS science_book, SUM(if(math_paper = 1, 1, 0)) AS math_paper, SUM(if(math_book = 1, 1, 0)) AS math_book, SUM(if(english_paper = 1, 1, 0)) AS english_paper, SUM(if(english_book = 1, 1, 0)) AS english_book, SUM(if(gk_paper = 1, 1, 0)) AS gk_paper, SUM(if(gk_book = 1, 1, 0)) AS gk_book, SUM(if(commerce_paper = 1, 1, 0)) AS commerce_paper, SUM(if(commerce_book = 1, 1, 0)) AS commerce_book, SUM(if(bio_paper = 1, 1, 0)) AS bio_paper, SUM(if(bio_book = 1, 1, 0)) AS bio_book');

        $nof->from('olympiad_student as olympiad_student');
        
        $nof->group_by('olympiad_student.school', 'ASC');
        $nof->group_by('olympiad_student.class', 'ASC');

        $nof->order_by('olympiad_student.school', 'ASC');
        $nof->order_by('olympiad_student.class', 'ASC');

        $query = $nof->get();

        $result = $query->result_array();

        return $result;
    }
}
