<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: difan
 * Date: 9/16/2015
 * Time: 1:48 PM
 */
class topic_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function GetAllTopics(){
        $query = $this->db->get('topic');
        return $query->result();
    }

    function GetAllTopicsWithQuiz(){
        $query = $this->db->query('select t.topicId,topicName,courseID,quizId,quizName from topic t left join quiz q on q.topicId = t.topicId');
        return $query->result();
    }

    function Insert($data){
        $this->db->insert('topic',$data);
        return $this->db->insert_id();
    }

}