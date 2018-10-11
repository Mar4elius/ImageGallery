<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$user_name = $this->tank_auth->get_username();
?>
<?php if (isset($result)): ?>
    <h1>Welcome <?php echo $user_name?>. Here you can manage your gallery! </h1>
    <div class="row">
        <?php foreach ($result as $row): ?>
            <div class="col-lg-3">
                <div class="thumbnail">
                    <p style="text-align: center;"><b><?php echo $row->imgTitle?></b></p>
                    <a href="<?php echo base_url(); ?>imageCMS/singleimagedetails/<?php echo $row->imgID; ?>">
                    <img <?php echo "src=" . base_url() . "thumbs/" . $row->imgFile; ?> class="img-rounded"></a>


                    <div class="caption" style="text-align: center;">
                        <a href="<?php echo base_url(); ?>imageCMS/delete_image/<?php echo $row->imgID; ?>"
                           class="btn btn-danger"/><i
                                class="fa fa-trash"></i>Delete</a>
                        <a href="<?php echo base_url(); ?>imageCMS/edit_image/<?php echo $row->imgID; ?>"
                           class="btn btn-primary"/><i
                                class="fa fa-edit"></i>Edit</a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
<?php endif; ?>
