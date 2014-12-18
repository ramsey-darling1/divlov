
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
            <h3 class="txt_style1"><?php if(isset($profile_name)){echo $profile_name;}?></h3>
        </div>
    </div>
    <div id="more_actions" class="right">
        <ul class="inline">
            <li><a class="btn_style2" id="opener">message me</a></li>
            <li><a href="" class="btn_style2">read my blog</a></li>
            <li><a href="" class="btn_style2">add to favorites</a></li>
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
            echo "<li>{$details[0]->state} | </li>";
            echo "</ul>";
        }
    ?>
<br />
    <?php
        if(isset($looking4)){
            echo "<h4 class='txt_style2'>I am looking for:</h4>";
            echo "<ul class='inline'>";
            echo "<li>{$looking4[0]->orientation} | </li>";
            echo "<li>{$looking4[0]->gender} | </li>";
            echo "<li>ages {$looking4[0]->age} to {$looking4[0]->age2}| </li>";
            echo "<li>who are {$looking4[0]->status} | </li>";
            echo "<li>for {$looking4[0]->looking_for} | </li>";
            echo "<li>I am also into {$looking4[0]->alternatives}</li>";
            echo "</ul>";
        }
    ?>
<br />
<div id="accordion">
  <h3>My Images</h3>
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
        }
    ?>    
  </div>
  <h3>My Bio</h3>
  <div>
    <p>
    Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
    purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
    velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
    suscipit faucibus urna.
    </p>
  </div>
  <h3>My Interests</h3>
  <div>
    <p>
    Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
    Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
    ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
    lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
    </p>
    <ul>
      <li>List item one</li>
      <li>List item two</li>
      <li>List item three</li>
    </ul>
  </div>
  <h3>My Hitest</h3>
  <div>
    <p>
    Cras dictum. Pellentesque habitant morbi tristique senectus et netus
    et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
    faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
    mauris vel est.
    </p>
    <p>
    Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
    Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
    inceptos himenaeos.
    </p>
  </div>
</div>

</div>

<!-- hidden compose form-->
<div class="dialog">
    <div class="new_message_wrap">
        <h3 class="txt_style2">Compose</h3>
        <form name="new_message" method="post" action="/index.php/messaging/send_message" class="form_style1">
            <input name="to" type="text" required="required" placeholder="to" value="<?php if(isset($username)){echo $username;}?>"/>
            <input name="subject" type="text" placeholder="subject"/>
            <textarea name="message" required="required" placeholder="message"></textarea>
            <input type="submit" name="new_message_action" value="Send Message" class="btn_style1"/>
        </form>
    </div>
</div>