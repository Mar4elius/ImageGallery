<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestImage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        //echo base_url()."uploads/y5oItBz.jpg";
        //echo base_url()."/thumbs";


        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/y5oItBz.jpg';
        $config['create_thumb'] = TRUE;
        $config['new_image'] = './thumbs/';
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 75;
        $config['height']       = 50;


        $imagePath = "./uploads/Landscape_4.jpg";
        //echo $imagePath;


        $exifData = exif_read_data($imagePath);

        if(!empty($exifData['Orientation']))
        {
            echo "ok";
            $orientation = $exifData['Orientation'];

            echo $orientation;
        }else{
            echo "no";

    }






        $this->load->library('image_lib', $config);

        //$this->image_lib->resize();
        $this->image_lib->initialize($config);


        if ( ! $this->image_lib->resize())
        {
            echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear(); // clear all the data before performing rotation of the image;
        $config = array();

        $config['image_library'] = 'gd2';
        //$config['library_path'] = '/usr/bin/';
        $config['source_image'] = './uploads/7694741.JPG';
        $config['rotation_angle'] = '90';

        $this->image_lib->initialize($config);

        if ( ! $this->image_lib->rotate())
        {
            echo $this->image_lib->display_errors();
        }
        
        
        
        
        

        $this->load->view('includes/header');
        $this->load->view('test_view');
        $this->load->view('includes/footer');
    }
}

