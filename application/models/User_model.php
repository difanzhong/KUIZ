<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: difan
 * Date: 9/14/2015
 * Time: 10:27 PM
 */
class user_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function user_insert($data){
        $this->db->insert('user',$data);
        return $this->db->insert_id();
    }

    function isValid($studentNo){
        //check whether the student number is in database
        $this->db->select('COUNT(*)');
        $this->db->where('student_no',$studentNo);
        $query = $this->db->get('user');
        $num = $query->result_array()[0]['COUNT(*)'];

        return $num == 1?true:false;
    }

    function user_update($data){
        $this->db->where('student_no',$data['student_no']);
        $this->db->update('user',$data);
        return $this->db->affected_rows();
    }

    function GetDetails($studentNo){
        $this->db->where('student_no',$studentNo);
        $query = $this->db->get('user');
        return $query->result();
    }

}