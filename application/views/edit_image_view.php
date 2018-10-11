<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ($result) {
    foreach ($result as $row) {
        $imgID = $row->imgID;
        $imgTitle = $row->imgTitle;
        $imgDescription = $row->imgDescription;
        $imgFile = $row->imgFile;
    }
}

?>

<h1> Edit Image Information</h1>
<div class="row">
    <div class="row">
        <div class="col-lg-4">
            <?php echo form_open_multipart("ImageCMS/edit_image/$imgID"); ?>
            <div class="form-group">
                <label for="imgTitle"><h4>Title</h4></label>
                <input type="text" name="imgTitle" class="form-control"
                       value="<?php echo set_value('imgTitle', $imgTitle); ?>">
                <?php echo form_error('imgTitle'); ?>
            </div>
            <div class="form-group">
                <label for="imgDescription"><h4>Content</h4></label>
                <textarea name="imgDescription" class="form-control textarea-height">
                  <?php echo set_value('imgDescription', $imgDescription); ?></textarea>
                <?php echo form_error('imgDescription'); ?>
            </div>
<!--            <div class="form-group">
                <label for="userFile">File</label>
                <input type="file" name="userFile" size="20"/>
            </div>-->
            <div class="form-group">
                <input type="submit" name="submit" value="Update" class="btn btn-success">
            </div>

            </form>
        </div>
        <div class="col-lg-8">
            <div class="well">
                <img <?php echo "src=" . base_url() . "display/". $imgFile; ?> class="img-rounded center-block" style="width: 75%">
            </div>

        </div>
    </div>
</div>
