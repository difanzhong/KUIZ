<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "uq/auth.php"; // for retrieving user information from server
auth_require();

/**
 * Created by PhpStorm.
 * User: difan
 * Date: 9/8/2015
 * Time: 10:30 PM
 */
class User extends CI_Controller
{
    public function Index(){

        //load resources
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');

        // check whether this is a new user, if not, get user details from database
        $students = null;
	    $student_no = auth_get_payload()['user'];
        if ($this->user_model->isValid($student_no)){
            $students = $this->user_model->GetDetails($student_no);
        }

        // load view with packaged data
        $data['user'] = $students;
        $this->load->view('Master/header');
        $this->load->view('User/setting',$data);
    }

    public function do_upload(){

        //load resources
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('user_model');

        // get user's student number, name and email from server
        $student_no = auth_get_payload()['user'];
        $student_name = auth_get_payload()['name'];
        $student_email = auth_get_payload()['email'];

        // upload limitation settings
        $config = array(
            'upload_path' => './uploads',
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "768",
            'max_width' => "1024",
            'file_name' => $student_no // student number
        );

        $this->load->library('upload',$config);

        $this->form_validation->set_rules('nickname','Nickname','required|min_length[3]|max_length[15]|alpha_numeric');

        $this->load->model('user_model');

        // check if form is validated and file is uploaded
        if ($this->upload->do_upload()&& $this->form_validation->run() ) {
            $upload_data = $this->upload->data();
            $insert_data = array('student_no' => $student_no, 'name' => $student_name, 'email' => $student_email,
                'nickname' => $this->input->post('nickname'),
                'avatar' => $upload_data['orig_name']);

            // check if user is a new user, insert into database. otherwise update it
            $num = 0;
            if (!$this->user_model->isValid($student_no)) {
                $num = $this->user_model->user_insert($insert_data);
            } else {
                $num = $this->user_model->user_update($insert_data);
            }

            if ($num > 0) {
                $session_arr = array(
                    'username' => $this->input->post('nickname'),
                    'avatar' => $upload_data['orig_name']
                );
                $this->session->set_userdata($session_arr);
                redirect('/Welcome');
            }
        }
        else{
            // collect errors
		    $err = array('error' => null);
            if ($this->form_validation->run() == false) {
                $form_err = validation_errors();
                if($this->user_model->isValid($student_no)){
                    $err = array('form_err'=>$form_err);
                }
                else{
                    $err = array('form_err'=>$form_err, 'error' => $this->upload->display_errors());
                }
            }
            else if($this->user_model->isValid($student_no)){
                $insert_data = array('student_no'=>$student_no,'name'=>$student_name,'email'=> $student_email,
                    'nickname'=>$this->input->post('nickname'));
                $num = $this->user_model->user_update($insert_data);
                if ($num == 1){
                    $this->session->set_userdata('username',$this->input->post('nickname'));
                    redirect('/Welcome');
                }
            }

            $data = array('error'=>$err["error"]);
            $this->session->set_flashdata('error',$data);
            redirect('/User/Index');
        }
    }

    public function Logout(){
        $this->session->sess_destroy();
    }
}