<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h1>Upload your image</h1>

<?php /*echo $error; */?>

<div style="max-width:400px;">
    <?php echo form_open_multipart('ImageCMS/do_upload'); ?>
    <div class="form-group">
        <label for="imgTitle">Title</label>
        <input type="text" name="imgTitle" class="form-control" value="<?php echo set_value('imgTitle'); ?>">
        <?php echo form_error('imgTitle'); ?>
    </div>
    <div class="form-group">
        <label for="imgDescription">Content</label>
        <textarea name="imgDescription" class="form-control textarea-height"
                  value="<?php echo set_value('imgDescription'); ?>"></textarea>
        <?php echo form_error('imgDescription'); ?>
    </div>
    <div class="form-group">
        <label for="userFile">File</label>
        <input type="file" name="userFile" size="20"/>
    </div>
    <div class="form-group">

        <input type="submit" name="submit"  value="upload" class="btn btn-success">

    </div>

    </form>
</div>

