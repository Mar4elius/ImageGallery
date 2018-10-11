<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- The array items passed from the Controller then become PHP variable we can write -->


<?php if (isset($result)): ?>
    <div class="row">
        <div class="col-lg-6 well">
            <h1>Image Gallery CMS Project</h1>
            <h6>Created by Igor Marchenko</h6>
            <p>This project is the simplified version of famous online resource <a href="https://www.deviantart.com">DeviantArt</a>. I used quite a few different
            technologies in order to create this project. They are: </p>
            <ul>
                <li>Codeigniter MVC framework</li>
                <li>PHP</li>
                <li>MySQL</li>
                <li>JavaScript/Jquery</li>
                <li>Bootstrap</li>
            </ul>
            <p>The main page of this project is styled using </p> <a href="https://masonry.desandro.com/">Masonry</a> Cascading grid layout library. For authentication functionality <a href="https://konyukhov.com/soft/tank_auth/">Tank Auth</a> takes care.</p>
            <h3>What you can do in this application?</h3>
            <p>This application allows you to create your own profile. After registration CRUD functionality will be available to you. Additionally, you can rate yours and other users images. For uploading images, back-end code takes care to rotate images in correct orientation, if by chance, your image has was uploaded with other than 0%.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h1><b>Image Gallery</b></h1>
        </div>
    </div>
    <div id="grid" class="container">
        <div id="posts">
            <?php foreach ($result as $row): ?>

                <div class="post hvr-grow">
                    <a href="<?php echo base_url(); ?>imageCMS/singleimagedetails/<?php echo $row->imgID;?>"><img <?php echo "src=".base_url()."display/" . $row->imgFile .">"?></a><br>
                    <br>
                    <strong><?php echo $row->imgTitle; ?></strong><strong>by <?php echo $row->username; ?></strong>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <h1>wrong</h1>

<?php endif; ?>
