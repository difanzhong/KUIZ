<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: difan
 * Date: 9/16/2015
 * Time: 11:48 AM
 */
class Quiz extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // load resources for all functions in the class
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('topic_model');
        $this->load->model('quiz_model');
        $this->load->model('question_model');
        $this->load->model('answer_model');
    }
    public function Create(){
        /* to create topics and quizes */

        //get topics with quizes that currently have
        $topics = $this->topic_model->GetAllTopics();
        if($topics){
            foreach($topics  as $t){
                $tid = $t->topicId;
                $quizes = $this->quiz_model->GetQuizesById($tid);
                $t->quizes = $quizes;
            }
        }

        // load view with packaged data
        $data['topics'] = $topics;
        $this->load->view('Master/header');
        $this->load->view('Quiz/create',$data);

    }

    public function save(){
        /* save new created topic */
        $data_insertion = array(
            'topicName' => $this->input->post('topicname')
        );
        $num = $this->topic_model->Insert($data_insertion);

        if($num > 0)
            redirect('Quiz/create');
    }

    public function save_quiz(){
        /* save new created quiz */
        $data_insertion = array(
            'quizName' => $this->input->post('quizname'),
            'quizSize' => intval($this->input->post('quizsize')),
            'topicId' => intval($this->input->post('topicid'))
        );
        $num = $this->quiz_model->Insert($data_insertion);

        if($num > 0)
            redirect('Quiz/create');
    }

    public function question(){
        /* view details of a specific quiz */

        $quiz_id = $this->input->post('quizid');
        if ($quiz_id == null) {
            $quiz_id = $this->session->flashdata('quiz_id');
            if($quiz_id == null)redirect('/Welcome');
        }

        // check if there are any questions belong to this questions
        $questions = $this->question_model->GetQuestoinsByQuizId($quiz_id);
        if ($questions){
            foreach ($questions as $q) {
                $qid = $q->question_id;
                // get answers from method in answer_model.php using question_id
                $answers = $this->answer_model->GetAnswersByQid($qid);
                if ($answers) {
                    $q->answers = $answers;
                }
            }
        }

        // get details of this quiz
        $quiz = $this->quiz_model->GetQuizById($quiz_id);

        // load quiz view with packaged data
        $data['title'] = $quiz->quizName;
        $data['size'] = $quiz->quizSize;
        $data['Launched'] = $quiz->Launched;
        $data['quiz_id'] = $quiz_id;
        $data['questions'] = $questions;
        $this->load->view('Master/header');
        $this->load->view('Quiz/view_question',$data);
    }

    public function add_question(){
        /* to save new added questions into database*/

        if (isset($_REQUEST)){
            // collect input details
            $q_content = $this->input->post("question");
            $c_answer = $this->input->post("correctAns");
            $answers = $this->input->post("answer");
            $quiz_id = $this->input->post("quizid");

            $data_q = array(
                "q_content"=>$q_content,
                "q_type"=>"MCQ"
            );

            $question_id = $this->question_model->insert($data_q,$c_answer,$answers);
            $data_qq = array(
                'question_id' => $question_id,
                'quizId' => $quiz_id
            );
            $this->quiz_model->InsertQuestionQuiz($data_qq);

            $this->session->set_flashdata('quiz_id',intval($quiz_id));
            redirect('Quiz/question');
        }
    }

    public function Launch(){
        /* launch a completed quiz */
        if(isset($_REQUEST)) {
            $quizid = $this->input->post('quizid');
            $update_data = array(
                'quizId' => intval($quizid),
                'Launched' => 1
            );
            $num = $this->quiz_model->Update($update_data);
            if ($num == 1)
                redirect('Quiz/create');
        }
    }
}