<?php

class ImageCMS_model extends CI_Model
{
    //don't know why we need this in this case
    function __construct()
    {
        parent::__construct();
    }

    function upload_image($data)
    {
        $this->db->insert('cms_image', $data);
    }

    function get_image_details($imageID)
    {
        $this->db->join('users AS U', 'cms_image.authorID = U.id', 'INNER');
        $this->db->where('cms_image.imgID', $imageID);

        $query = $this->db->get('cms_image');

        return $query->result();
    }

    function get_all_images()
    {
        $this->db->join('users AS U', 'cms_image.authorID = U.id', 'INNER');
        $query = $this->db->get('cms_image');

        return $query->result();
    }

    function get_images_by_authorID($authorID)
    {
        $this->db->join('users AS U', 'cms_image.authorID = U.id', 'INNER');
        $this->db->where('authorID', $authorID);
        $query = $this->db->get('cms_image');

        return $query->result();
    }
    function delete_image($imgID)
    {
        $this->db->where('imgID', $imgID);
        $this->db->delete('cms_image');
    }

    function edit_image($imgID, $data)
    {
        $this->db->where('imgID', $imgID);
        $this->db->update('cms_image', $data);
    }


    //rating methods
    function insert_cms_image_ratings($data)
    {
        $this->db->insert('cms_image_ratings', $data);
    }

    function get_ratings_for_image($imgID, $raterID)
    {
        $this->db->where('imgID', $imgID);
        $this->db->where('raterID', $raterID);
        $query = $this->db->get('cms_image_ratings');

        return $query->result();
    }

    function get_avr_image_rating($imgID)
    {
        $this->db->select('AVG(rating) AS average, COUNT(rating) AS quantity');
        $this->db->where('imgID', $imgID);
        $query = $this->db->get('cms_image_ratings');

        return $query -> result();
    }
    // \ rating methods




    //comments methods
    function get_image_comments($imgID)
    {
        $this->db->join('users AS U', 'cms_image_comments.authorID = U.id', 'INNER');
      $this->db->where('imgID', $imgID);
      $query = $this->db->get('cms_image_comments');

      return $query->result();
    }

    function insert_img_comment($data)
    {
        $this->db->insert('cms_image_comments',$data);
    }
    // \ comments methods
}

?>
