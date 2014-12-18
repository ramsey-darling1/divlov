 <?php $this->load->helper('form');?>
<div id="upload_image_page" class="form_style1">
    <h3 class="txt_style1">My Pics</h3>
    <br />
    <p><a id="opener" class="btn_style1 pad">upload new pic</a></p>
    <br />
    <?php
        if(isset($pics) and @$pics != ''){
            foreach($pics as $pic){
                if($pic[0]->image_type == 'jpeg'){
                    //change jpeg to jpg so it can be used in the file path
                    $pic[0]->image_type = 'jpg';
                }
                echo '<div class="user_image">';
                echo '<img src="/assets/userimages/'.$pic[0]->raw_name.'.'.$pic[0]->image_type.'" alt="'.$pic[0]->raw_name.'" '.$pic[0]->image_size_str.' />';
                echo '<div class="dissapear"><div class="make_profile_pic"><a href="/index.php/images/make_profile_pic/'.$pic[0]->pic_id.'">make profile pic</a>';
                echo ' | <a href="/index.php/images/set_profile_bg_image/'.$pic[0]->pic_id.'">make profile background</a>';
                echo ' | <a href="/index.php/images/delete_pic/'.$pic[0]->pic_id.'">delete pic</a></div></div>';
                echo '</div>';
            }
        }
    ?>    
   
    
</div>

<div class="dialog form_style1">
    <h3 class="txt_style1">Upload New Pic</h3>
    <?php echo form_open_multipart('images/upload',array('id'=> 'upload_image_form'));?>

    <input type="file" name="userfile" />
        
    <!--<input type="submit" value="upload" class="btn_style1" />-->
    
    <p id="upload_image_trigger" class="btn_style1 pad show_inline">upload</p>

    </form><!--openin form tag is being generated-->
    

</div>