
<div class="left" id="homepage">
    <h3 class="txt_style1">Home</h3>
        <div class="profile_pic">
            <?php
                if(isset($profile_pic) and @$profile_pic != ''){
                    //display the users profile pic
                    if($profile_pic[0]->image_type == 'jpeg'){
                        //change jpeg to jpg so it can be used in the file path
                        $profile_pic[0]->image_type = 'jpg';
                    }
                    echo '<a href=""><img src="/assets/userimages/'.$profile_pic[0]->raw_name.'.'.$profile_pic[0]->image_type.'" alt="'.$profile_pic[0]->raw_name.'" /></a>';
                }else{
                    //display the default profile pic
                    echo '<a href=""><img src="/assets/images/profilepic.jpg" alt="default pic" /></a>';
                }
            ?>
            
        </div>
    <p><?php if(isset($username)){echo $username;}?></p>
    <ul class="homepage_action">
        <li><a href="/index.php/pages/profile" class="btn_style1 pad">View Profile</a></li>
        <li><a href="/index.php/pages/messaging" class="btn_style1 pad">Check Messages</a></li>
        <li><a href="/index.php/pages/upload_images" class="btn_style1 pad">My Pics</a></li>
        <li><a href="/index.php/pages/people" class="btn_style1 pad">Find Someone</a></li>
        <li><a href="/index.php/pages/random_match" class="btn_style1 pad">Random Match</a></li>
    </ul>
</div>
<div class="right" id="homepage_right">
    <?php if(isset($slideshow_users)):?>
    <h3 class="txt_style1">Featured Users</h3>
    <div id="homepage_slideshow_no">
        <div id="slides_no">
            <div class="slides_container_no banner_no">
                <?php
                
                    if(!empty($slideshow_users)){
                        echo '<ul>';
                        foreach($slideshow_users as $slide){
                            if($slide['profile_pic'] == 'default'){
                                echo '<li class=""><a href="/index.php/pages/profile/'.@$slide['username'].'"><img src="/assets/images/profilepic.jpg" alt="default pic" /></a>';
                                echo '<p class="pad link_style1 dark_overlay"><a href="/index.php/pages/profile/'.@$slide['username'].'">'.@$slide['username'].'</a></p></li>';
                            }else{
                                if($slide['profile_pic'][0]->image_type == 'jpeg'){
                                      //change jpeg to jpg so it can be used in the file path
                                      $slide['profile_pic'][0]->image_type = 'jpg';
                                }
                              echo '<li><a href="/index.php/pages/profile/'.@$slide['username'].'"><img src="/assets/userimages/'.$slide['profile_pic'][0]->raw_name.'.'.$slide['profile_pic'][0]->image_type.'" alt="" /></a>';
                              echo '<p class="pad link_style1 dark_overlay"><a href="/index.php/pages/profile/'.@$slide['username'].'">'.@$slide['username'].'</a></p></li>';
                            }
                                
                        }
                        echo '</ul>';
                    }else{
                        echo "<p>Sorry, we can not load any featured users at this time.</p>";
                    }
                    
                ?>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>

