<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImageCMS extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->load->model('ImageCMS_model');
        $data['result'] = $this->ImageCMS_model->get_all_images();
        //print_r($data);
        $this->load->view('includes/header');
        $this->load->view('home_view', $data);
        $this->load->view('includes/footer');

    }

    public function do_upload()
    {
        //Tank auth
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            $data['user_id'] = $this->tank_auth->get_user_id();
            $data['username'] = $this->tank_auth->get_username();
            //$this->load->view('welcome', $data);
        }//\ Tank Auth
        //validation
        $this->load->library('form_validation'); // load this library only for this function
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('imgTitle', 'Title', 'required|min_length[10]');
        $this->form_validation->set_rules('imgDescription', 'Description', 'required|min_length[50]');
        //$this->form_validation->set_rules('userFile', 'Image', 'required');

        if ($this->form_validation->run() == FALSE) { //validation has not been met OR form shown for the first time
            $this->load->view('includes/header');
            $this->load->view('imageCms_upload_view');
            $this->load->view('includes/footer');
        } else {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 4096;
            $config['max_height'] = 2160;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userFile')) {
                //$error = array('error' => $this->upload->display_errors());

                //$this->load->view('upload_form', $error);

            } else {
                $data = array('upload_data' => $this->upload->data());

                $datadb['imgTitle'] = $this->input->post('imgTitle');
                $datadb['imgDescription'] = $this->input->post('imgDescription');
                $upload_data = $this->upload->data(); //gets data of upload file;

                $datadb['imgFile'] = $upload_data['file_name'];
                $datadb['authorID'] = $this->tank_auth->get_user_id();

                $this->load->model('ImageCMS_model');
                $this->ImageCMS_model->upload_image($datadb);
                $this->session->set_flashdata('message', 'Insert Successful');


                //RESIZE, ROTATE ORIGINAL IMAGE

                $orgImgName = $this->upload->data('file_name');
                $orgImgFilePath = $this->upload->data('full_path');


                //resize for display image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/' . $orgImgName;
                $config['create_thumb'] = FALSE;
                $config['new_image'] = './display/';
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 1024;
                $config['height'] = 768;

                $this->load->library('image_lib', $config);

                //$this->image_lib->resize();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                } else //rotate image
                {
                    $config['image_library'] = 'gd2';
                    //$config['library_path'] = '/usr/bin/';
                    $config['source_image'] = './display/' . $orgImgName;

                    $exif = exif_read_data($orgImgFilePath);
                    if (!empty($exif['Orientation'])) {
                        switch ($exif['Orientation']) {
                            case 1: // no need to perform any changes
                                $config['rotation_angle'] = '0';
                                break;
                            case 2: //horizontal flip
                                $config['rotation_angle'] = 'hor';
                                break;
                            case 3:// 180 rotate left
                                $config['rotation_angle'] = '180';
                                break;
                            case 4: // vertical flip
                                $config['rotation_angle'] = 'vrt';
                                break;
                            case 5:// vertical flip + 90 rotate right
                                $config['rotation_angle'] = 'vrt';
                                $config['rotation_angle'] = '270';
                                break;
                            case 6: // 90 rotate right
                                $config['rotation_angle'] = '270';
                                break;
                            case 7: // horizontal flip + 90 rotate right
                                $config['rotation_angle'] = 'hor';
                                $config['rotation_angle'] = '270';
                                break;
                            case 8: // 90 rotate left
                                $config['rotation_angle'] = '90';
                                break;
                            default:
                                $config['rotation_angle'] = '0';
                                break;
                        }
                        $this->image_lib->initialize($config);


                        if (!$this->image_lib->rotate()) {
                            echo $this->image_lib->display_errors();
                        }
                    }
                }

                //resize for thumb image
                $this->image_lib->clear();

                $config['image_library'] = 'gd2';
                $config['source_image'] = './display/' . $orgImgName;
                $config['create_thumb'] = FALSE;
                $config['new_image'] = './thumbs/';
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 200;
                $config['height'] = 150;

                $this->load->library('image_lib', $config);

                //$this->image_lib->resize();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }


                redirect("imageCMS/index", "location");
            }


            /*$this->load->view('includes/header');
            $this->load->view('imageCms_upload_view'); //, array('error' => ' ')
            $this->load->view('includes/footer');*/


            //$this->load->view('upload_success', $data);
        }
    } // \ upload;

    public function singleImageDetails($imgID)
    {
        $this->load->library('form_validation');
        $this->load->model('ImageCMS_model');

        $data['result'] = $this->ImageCMS_model->get_image_details($imgID);
        $data['imgComments'] = $this->ImageCMS_model->get_image_comments($imgID);

        if ($data['result']) {
            foreach (($data['result']) as $row) {
                $authorID = $row->authorID;
            }
            $data['allImages'] = $this->ImageCMS_model->get_images_by_authorID($authorID);

        }
        // get info for rating
        $data['imgVotesAvg'] = $this->ImageCMS_model->get_avr_image_rating($imgID);

        //check if user is logged in in order to rate the picture

        $data['user_id'] = $this->tank_auth->get_user_id();
        $dataRating['rating'] = $this->input->post('star');

        if ($dataRating['rating'] != 0) {
            if (!$this->tank_auth->is_logged_in()) {
                //redirect('/auth/login/');
                $this->session->set_flashdata('warning', 'You must login in order to rate the picture!');
            } else {

                $dataRating['imgID'] = $imgID;
                $dataRating['raterID'] = $this->input->post('raterID');

                //check if user has already rated this picture;
                $dataImage['result'] = $this->ImageCMS_model->get_ratings_for_image($dataRating['imgID'], $dataRating['raterID']);

                if (empty($dataImage['result'])) { // A variable is considered empty if it does not exist or if its value equals FALSE.
                    $this->ImageCMS_model->insert_cms_image_ratings($dataRating);
                    $this->session->set_flashdata('message', 'Thank you for your vote!');
                    redirect("imageCMS/singleImageDetails/$imgID", "location");
                } else {
                    $this->session->set_flashdata('info', 'You have already rated this image!');
                    redirect("imageCMS/singleImageDetails/$imgID", "location");
                }
            }
        }


//get image comments

//validation for comments form
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('commentArea', 'Comments', 'required|min_length[10]');
        $dataPost['postText'] = $this->input->post('commentArea');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/header');
            $this->load->view('imageCms_singleImage_view', $data);
            $this->load->view('includes/footer');

        } else {

            $dataPost['imgID'] = $imgID;
            $dataPost['authorID'] = $this->tank_auth->get_user_id();
            $this->ImageCMS_model->insert_img_comment($dataPost);
            $this->session->set_flashdata('message', 'Your comment was added successfully!');

            /*$this->load->view('includes/header');
            $this->load->view('imageCms_singleImage_view', $data);
            $this->load->view('includes/footer');*/
            redirect("imageCMS/singleImageDetails/$imgID", "location");
        }
// \ form validation


         /* echo "<pre>";
          print_r($data);
           echo "</pre>";*/
    } // \singleImageDetails

    public
    function manage_images()
    {
        //$data['userid'] = $this->tank_auth->get_user_id();
        $userID = $this->tank_auth->get_user_id();
        $this->load->model('ImageCMS_model');
        $data['result'] = $this->ImageCMS_model->get_images_by_authorID($userID);

        $this->load->view('includes/header');
        $this->load->view('manage_images_view', $data);
        $this->load->view('includes/footer');

    } // \ manage_images

    public
    function delete_image($imgID)
    {
        if (!is_numeric($imgID)) {
            redirect('/', 'location'); // redirect user out of this controller
        }
        $this->load->model('ImageCMS_model');
        $this->ImageCMS_model->delete_image($imgID);

        $this->load->view('includes/header');
        $this->load->view('manage_images_view');
        $this->load->view('includes/footer');

        redirect("imageCMS/manage_images", "location");
    }

    public
    function edit_image($imgID)
    {
        if (!is_numeric($imgID)) {
            redirect('/', 'location'); // redirect user out of this controller
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('imgTitle', 'Title', 'required|min_length[10]');
        $this->form_validation->set_rules('imgDescription', 'Description', 'required|min_length[50]');

        if ($this->form_validation->run() == FALSE) {

            $this->load->model('ImageCMS_model');

            $data['result'] = $this->ImageCMS_model->get_image_details($imgID);
            $this->load->view('includes/header');
            $this->load->view('edit_image_view', $data);
            $this->load->view('includes/footer');

            /* echo "<pre>";
             print_r($data);
             echo "</pre>";*/

        } else {
            $datadb['imgTitle'] = $this->input->post('imgTitle');
            $datadb['imgDescription'] = $this->input->post('imgDescription');

            $this->load->model('ImageCMS_model');
            $this->ImageCMS_model->edit_image($imgID, $datadb);

            $this->session->set_flashdata('message', 'Edit Successful');
            redirect("imageCMS/manage_images", "location");


        }

    }


}
