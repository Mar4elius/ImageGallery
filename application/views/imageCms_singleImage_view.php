<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$picRating;
$user_id = $this->tank_auth->get_user_id();
$user_name = $this->tank_auth->get_username();
if ($allImages) {
    $imgAmount = count($allImages); // count how many images are in the array. Can use this value to build a carousel menu(divide);
} else {
    echo "Error";
}
$times = 0;
$count = 0;
$startPoint = 0;

foreach ($allImages as $row){
    $galleryUsername = $row->username;
}

?>
<div class="container">
    <div class="span8">
        <h1><b>Check other images from <?php echo $galleryUsername ?></b></h1>
        <div class="well">
            <div id="myCarousel" class="carousel slide">
                <ol class="carousel-indicators">
                    <!--count how many times we can fit 4(amount of picture in carousel), so it gives us how many carousel we need to create-->
                    <?php
                    if($imgAmount <= 4 )
                    {
                        $times++;
                    }
                    else{
                        $times = (int)($imgAmount / 4);

                        if ($times % 4 != 0) {
                            $times++;
                        }
                    }

                    ?>

                    <?php for ($i = 0; $i < $times; $i++): ?>
                        <?php if ($i != 0): ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo $i ?>"></li>
                        <?php else: ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo $i ?>" class="active"></li>
                        <?php endif; ?>

                    <?php endfor; ?>
                </ol>

                <!-- Carousel items -->
                <div class="carousel-inner">


                    <?php for ($j = 0;
                    $j < $times;
                    $j++): ?>
                    <?php if ($j != 0): ?>
                    <div class="item">
                        <?php else: ?>
                        <div class="item active">
                            <?php endif; ?>

                            <div class="row-fluid">

                                <?php for ($k = $startPoint; $k < count($allImages); $k++): ?>
                                    <?php $array = (array)$allImages[$k]; ?>
                                    <?php for ($r = 0; $r < 1; $r++): ?>
                                        <div class="col-lg-3">
                                            <a href="<?php echo base_url(); ?>imageCMS/singleimagedetails/<?php echo $array['imgID']; ?>"
                                               class="thumbnail"><img <?php echo "src=" . base_url() . "/thumbs/" . $array['imgFile']; ?>
                                                        alt="Image" style="max-width:100%;"/></a>
                                        </div>
                                    <?php endfor; ?> <!--end for r loop-->

                                    <?php $count++; ?>
                                    <?php /*echo "Count: ".$count;*/ ?><!--
                                <?php /*echo "j: ".$j;*/ ?>
                                --><?php /*echo "k: ".$k;*/ ?>

                                    <?php if ($count == 4): ?>

                                        <?php $startPoint = $count; ?>
                                        <?php /*echo $startPoint, $count */ ?>
                                        <?php $count = 0; ?>

                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endfor; ?> <!--end for k loop-->

                            </div><!--/row-fluid-->
                        </div><!--/item-->
                        <?php endfor; ?> <!--end for j loop-->

                    </div> <!--carousel-inner-->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="fa fa-arrow-left fa-2x"></i></a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="fa fa-arrow-right fa-2x"></i></a>
                </div><!--myCarousel-->
            </div><!--well-->
        </div>
    </div>

    <?php if ($imgVotesAvg): ?>
        <div class="row">
            <div class="col-lg-6">
                <?php foreach ($imgVotesAvg as $row): ?>
                    <?php $picRating = number_format((float)$row->average, 1, '.', '') . "</b> out of <b>5</b> from " . $row->quantity . " members." ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        Wrong
    <?php endif; ?>

    <?php if (isset($result)): ?>
        <?php foreach ($result as $row): ?>
            <div class="row">

                <div class="col-lg-12">
                    <img <?php echo "src=" .base_url()."/display/" . $row->imgFile; ?> class="center-block well img-rounded"/>
                </div>
            </div>
            <!--star form-->
            <div class="row">
                <div class="col-lg-9">
                    <h4><?php echo "Picture rating is <b style='color:deeppink'>" . $picRating ?></h4>
                </div>
                <div class="col-lg-2">
                    <form id="ratingsForm" name="ratingForm" method="post" enctype="multipart/form-data"
                          action="" class="pull-right">

                        <div class="form-group stars pull-right">
                            <input type="radio" name="star" class="star-1" id="star-1" value="1">
                            <label class="star-1" for="star-1">1</label>
                            <input type="radio" name="star" class="star-2" id="star-2" value="2">
                            <label class="star-2" for="star-2">2</label>
                            <input type="radio" name="star" class="star-3" id="star-3" value="3">
                            <label class="star-3" for="star-3">3</label>
                            <input type="radio" name="star" class="star-4" id="star-4" value="4">
                            <label class="star-4" for="star-4">4</label>
                            <input type="radio" name="star" class="star-5" id="star-5" value="5">
                            <label class="star-5" for="star-5">5</label>
                            <span></span>
                        </div>
                        <div class="form-group hidden">
                            <input type="hidden" name="raterID" value="<?php echo $user_id?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary center-block" value="Submit">

                        </div>
                    </form>
                </div>
                <div class="col-lg-1"></div>
            </div>

            <!--end of star form-->
            <!--display image's text and author data-->
            <div class="row">
                <div class="col-lg-12">
                    <h1><b><?php echo $row->imgTitle; ?></b></h1>
                    <div class="pull-right well">
                        <span><b>Created on</b> <?php echo $row-> imgDate; ?></span>
                        <span><b>by </b> <?php echo $row->username; ?></span>
                        <!--<span><b>Email: </b> <?php /*echo $row->email; */ ?></span>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p><?php echo $row->imgDescription; ?></p>
                </div>
            </div>

            <div class="row">

            </div>
            <!--/ of display image's text and author data-->
        <?php endforeach; ?>
    <?php endif; ?>

    <!--  comment section-->

    <!--display comments-->
    <?php if ($imgComments): ?>
        <?php foreach ($imgComments as $row): ?>
            <div class="row">
                <h1></h1>
                <div class="col-lg-1">
                    <img <?php echo "src=\"" . base_url() . "pictures\default-user.png \";"; ?>
                            class="img img-rounded img-fluid" style="width: 70%"/>
                    <b><?php echo $row->username ?></b>
                </div>
                <div class="col-lg-6 well">
                    <h5 class="pull-right"><?php echo "<b>Created on:</b> " . $row->postDate?></h5>
                    <p class=""><?php echo $row->postText ?></p>
                </div>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>
    <!--/ of display comments-->

    <button data-toggle="collapse" data-target="#demo" class="btn btn-success" type="submit" name="button">Add your
        comment
    </button>
    </br>

    <?php if (isset($user_id)): ?>

        <div id="demo" class="collapse">
            <form method="post" name="commentsForm">
                <textarea id="mytextarea" name="commentArea" value="<?php echo set_value('content'); ?>"></textarea>
                <?php echo form_error('content'); ?>
            </br>
                <input type="submit" name="comment" class="btn btn-primary" value="Comment">
            </form>
        </div>
        <?php echo validation_errors(); ?>
    <?php else: ?>
        <div id="demo" class="collapse">
            <form>
                <div class="alert alert-info">
                <h3>In order to leave a comment you need to sing in. <a href="<?php echo base_url(); ?>auth/login/"
                                                                      class="btn btn-default"> Sign In</a></h3>
                </div>
            </form>
        </div>
    <?php endif; ?>
    <!--/ comment section-->
</div>




