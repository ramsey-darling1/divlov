<?php
if(isset($profile_bg)){
    if(!empty($profile_bg)){
        if($profile_bg[0]->image_type == 'jpeg'){
            $profile_bg[0]->image_type = 'jpg';//change jpeg to jpg so it can be used in the file path
        }
        echo "<style>";
        echo ".user_profile_bg { background: url(/assets/userimages/".$profile_bg[0]->raw_name.".".$profile_bg[0]->image_type.") no-repeat; }";
        echo ".user_profile_bg {background-size: cover;}";
        echo "</style>";   
    }
}
?>
<div id="add_fav_response"></div>
<div id="profile">
    <div class="user_profile_bg">
        <div id="profile_pic">
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
            <h3 class="txt_style1"><?php if(isset($p_username)){echo $p_username;}?></h3>
            <?php
                if(isset($own_profile)){
                    if($own_profile){
                        echo '<p class="link_style1"><a href="/index.php/pages/upload_images">change profile pic</a></p>';
                    }
                }
            ?>
        </div>
    </div>
    <script type="text/javascript" src="/assets/js/favorite.js"></script>
    <div id="more_actions" class="right">
        <ul class="inline">
            <?php $me_or_us = (isset($couple)) ? 'us' : 'me' ;?>
            <li><a class="btn_style2" id="opener">message <?php echo $me_or_us; ?></a></li>
            <?php $my_or_our = (isset($couple)) ? 'our' : 'my' ;?>
            <li><a href="/index.php/pages/blog/<?php echo @$p_username; ?>" class="btn_style2">read <?php echo $my_or_our; ?> blog</a></li>
            <li><a href="/index.php/favorites/add/<?php echo @$p_username; ?>" class="btn_style2" id="fav_trig">add to favorites</a></li>
        </ul>
    </div>
    <?php
        if(isset($details)){
            echo "<ul class='inline'>";
            echo "<li>{$details[0]->orientation} | </li>";
            echo "<li>{$details[0]->gender} | </li>";
            echo "<li>{$details[0]->age} | </li>";
            echo "<li>{$details[0]->relationship_status} | </li>";
            echo "<li>{$details[0]->city} | </li>";
            echo "<li>{$details[0]->state}</li>";
            
            if(isset($user_id)){
                if($user_id == $this->session->userdata('user_id')){
                    echo '<li class="link_style2"> | <a href="/index.php/profile/edit_details">edit</a></li>';
                }
            }
            
            echo "</ul>";
        }

        if(!empty($partners_details)){
            
            echo '<ul class="inline">';
            echo '<li>'.$partners_details[0]->orientation.' | </li>';
            echo '<li>'.$partners_details[0]->gender.' | </li>';
            echo '<li>'.$partners_details[0]->age.'</li>';
            echo '</ul>';
        }
    ?>
<br />
    <?php
        if(isset($looking4)){
            $look_4_text = (isset($couple)) ? 'We are looking for:' : 'I am looking for:' ;
            echo "<h4 class='txt_style2'>{$look_4_text}</h4>";
            echo "<ul class='inline'>";
            
            //display orientation preference
            switch ($looking4[0]->orientation){
                case 'straight':
                    echo "<li>Straight | </li>";
                    break;
                case 'gay':
                    echo "<li>Gay | </li>";
                    break;
                case 'lesbian':
                    echo "<li>Lesbian | </li>";
                    break;
                case 'bi':
                    echo "<li>Bi | </li>";
                    break;
                case 'queer':
                    echo "<li>Queer | </li>";
                    break;
                case 'fluid':
                    echo "<li>Fluid | </li>";
                    break;
                case 'other':
                    echo "<li>Ask About my Orientation Preferance  | </li>";
                    break;
                case 'nomatter':
                    echo "<li>Orientation Doesn't Matter | </li>";
                    break;
                default :
                    echo "<li>Orientation not Known | </li>";
            }
            
            //display gender preference
            switch ($looking4[0]->gender){
                case 'male':
                    echo "<li>Males | </li>";
                    break;
                case 'female':
                    echo "<li>Females | </li>";
                    break;
                case 'malesandfemales':
                    echo "<li>Males and Females | </li>";
                    break;
                case 'transmtof':
                    echo "<li>Trans M to F | </li>";
                    break;
                case 'transftom':
                    echo "<li>Trans F to M | </li>";
                    break;
                case 'androgyne':
                    echo "<li>Androgyne | </li>";
                    break;
                case 'everyone':
                    echo "<li>Everyone | </li>";
                    break;
                case 'couple':
                    echo "<li>A Couple | </li>";
                    break;
                case 'nomatter':
                    echo "<li>Gender Doesn't Matter | </li>";
                    break;
                case 'other':
                    echo "<li>Ask About My Gender Preference | </li>";
                    break;
                default:
                    echo "<li>Gender Preference Unknown | </li>";
            }
            
            //display desired ages
            echo "<li>Ages {$looking4[0]->age} to {$looking4[0]->age2}| </li>";
            
            //display marital status
            switch ($looking4[0]->status){
                case 'single':
                    echo "<li>Who Are Single | </li>";
                    break;
                case 'dating':
                    echo "<li>Who Are Dating | </li>";
                    break;
                case 'married':
                    echo "<li>Who Are Married | </li>";
                    break;
                case 'poly':
                    echo "<li>Who Are Poly | </li>";
                    break;
                case 'other':
                    echo "<li>Ask About My Relationship Status Preference | </li>";
                    break;
                case 'nomatter':
                    echo "<li>Relationship Status Doesn't Matter | </li>";
                    break;
                default:
                    echo "<li>Relationship Status Preference Unkown | </li>";
            }
            
            //display looking for relationship
            switch ($looking4[0]->looking_for){
                case 'longterm';
                    echo "<li>For a Long Term Relationship | </li>";
                    break;
                case 'shortterm';
                    echo "<li>For a Casual Relationship | </li>";
                    break;
                case 'hookup';
                    echo "<li>To Hookup With | </li>";
                    break;
                case 'friends';
                    echo "<li>For Friendship | </li>";
                    break;
                case 'fwb';
                    echo "<li>For a Freinds With Benefits Situation | </li>";
                    break;
                case 'dating';
                    echo "<li>For a Dating Relationship | </li>";
                    break;
                case 'poly';
                    echo "<li>For a Poly Relationship | </li>";
                    break;
                case 'open';
                    echo "<li>For an Open Relationship | </li>";
                    break;
                case 'other';
                    echo "<li>Ask About What Kind of Relationship I am interested in | </li>";
                    break;
                case 'nomatter';
                    echo "<li>Let's See What Happens | </li>";
                    break;
                default:
                    echo "<li>Desired Type of Relationship Unknown | </li>";
            }
            
            //display alternative things that one might be into
            switch ($looking4[0]->alternatives){
                case '':
                    echo '';
                    break;
                case 'threesomes':
                    echo "<li>I am also into Threesomes</li>";
                    break;
                case 'threesomes':
                    echo "<li>I am open to being with a Couple</li>";
                    break;
                case 'groupplay':
                    echo "<li>I am also into Group Play</li>";
                    break;
                case 'roleplaying':
                    echo "<li>I am also into Role Playing</li>";
                    break;
                case 'bondage':
                    echo "<li>I am also into Bondage</li>";
                    break;
                case 'other':
                    echo "<li>Ask me what else I am into</li>";
                    break;
                case 'normal':
                    echo "<li>I am just into Normal Stuff</li>";
                    break;
                case 'none':
                    echo "<li>I am not into anything Kinky</li>";
                    break;
                default:
                    echo "";
                
            }
            
            
            echo "</ul>";
        }
    ?>
<br />
<?php $My_or_Our = (isset($couple)) ? 'Our' : 'My' ; ?>
<div id="accordion">
  <h3><?php echo $My_or_Our; ?> Images</h3>
  <div>
    <?php
        if(isset($pics) and @$pics != ''){
            foreach($pics as $pic){
                if($pic[0]->image_type == 'jpeg'){
                    //change jpeg to jpg so it can be used in the file path
                    $pic[0]->image_type = 'jpg';
                }
                echo '<div class="user_image">';
                echo '<img src="/assets/userimages/'.$pic[0]->raw_name.'.'.$pic[0]->image_type.'" alt="'.$pic[0]->raw_name.'" '.$pic[0]->image_size_str.' />';
                //echo '<div class="dissapear"><div class="make_profile_pic"><a href="/index.php/images/make_profile_pic/'.$pic[0]->pic_id.'">make profile pic</a></div></div>';
                echo '</div>';
            }
        }else{
            if(isset($user_id)){
                if($user_id == $this->session->userdata('user_id')){
                    echo '<a href="/index.php/pages/upload_images" class="btn_style2">add images</a>';
                }
            }
        }
    ?>    
  </div>
  <h3><?php echo $My_or_Our; ?> Bio</h3>
  <div>
    <p>
    <?php
        if(isset($bio)){
            echo @$bio[0]->bio;
        }
    ?>
    </p>
    <br />
    <?php
        if(isset($user_id)){
            if($user_id == $this->session->userdata('user_id')){
                echo '<a href="/index.php/profile/edit_bio" class="btn_style2">edit</a>';
            }
        }
    ?>
  </div>
  <h3><?php echo $My_or_Our; ?> Interests</h3>
  <div>
    <p>
    <?php
        if(isset($interests)){
            echo @$interests[0]->interests;
        }
    ?>
    </p>
     <br />
    <?php
        if(isset($user_id)){
            if($user_id == $this->session->userdata('user_id')){
                echo '<a href="/index.php/profile/edit_interests" class="btn_style2">edit</a>';
            }
        }
    ?>
  </div>
  <h3><?php echo $My_or_Our; ?> Custom Test</h3>
  <div>
    <p>
   <?php
        if(isset($hitest)){
            if(!empty($hitest)){
                $c = 1;
                foreach($hitest as $ht){
                    echo $c.'. '.htmlspecialchars($ht->question).'<br />';
                    $c = $c + 1;
                }
            }
        }
   ?>
    </p>
   <br />
    <?php
        if(isset($user_id)){
            if($user_id == $this->session->userdata('user_id')){
                echo '<a href="/index.php/pages/myhitest" class="btn_style2">edit</a>';
            }
        }else{
            echo '<a href="/index.php/hitest/take_myhitest/'.@$p_username.'" class="btn_style2">take Custom Test</a>';
        }
    ?>
  </div>
</div>

</div>

<!-- hidden compose form-->
<div class="dialog">
    <div class="new_message_wrap">
        <h3 class="txt_style2">Compose</h3>
        <form name="new_message" method="post" action="/index.php/messaging/send_message" class="form_style1">
            <input name="to" type="text" required="required" placeholder="to" value="<?php if(isset($p_username)){echo $p_username;}?>"/>
            <input name="subject" type="text" placeholder="subject"/>
            <textarea name="message" required="required" placeholder="message"></textarea>
            <input type="submit" name="new_message_action" value="Send Message" class="btn_style1"/>
        </form>
    </div>
</div>