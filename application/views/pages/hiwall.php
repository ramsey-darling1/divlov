
<div id="hiwall">
    <h3 class="txt_style1">The DivLov Wall</h3>
    <p>Here you can post a message that everyone on divlov can see. People's responses will go directly to your inbox.</p>
    <br />
    <p><a class="btn_style1 pad" id="opener">New Post</a></p>
    <br />
    <div id="posts_wrap" class="list_style2">
            <ul>
                <?php
                    if(isset($hiposts) and !empty($hiposts)){
                        
                        foreach($hiposts as $hipost){
                            echo '<li class="post link_style2">';
                            echo '<ul class="brick">';
                            echo '<li class="date_post_posted">';
                            echo '<a href="/index.php/pages/profile/'.$hipost->username.'">'.$hipost->username.'</a> '.date('m/d/y',$hipost->date_posted).'</li>';
                            echo '<li class="post_body">'.htmlspecialchars($hipost->hipost).'</li>';
                                echo '<li class="res_con"><p class="res_trig">Respond</p><ul class="dissapear">';
                                echo '<li class="comment_form"><form action="/index.php/messaging/response" method="post" class="form_style1">';
                                echo '<input type="hidden" name="hipost_id" value="'.$hipost->pid.'"/>';
                                echo '<input type="hidden" name="to_id" value="'.$hipost->user_id.'"/>';
                                echo '<textarea name="response" placeholder="response"></textarea>';
                                echo '<input type="submit" value="Respond" class="btn_style2" /></form></li>';
                                echo '</ul></li>';
                            echo '</ul>';
                            echo '</li>';
                        }
                    }else{
                        echo "<li>There are no posts</li>";
                    }
                ?>
               
            </ul>
    </div>
</div>

<!-- hidden compose form-->
<div class="dialog">
    <div class="new_message_wrap">
        <h3 class="txt_style2">New Post</h3>
        <form name="new_post" method="post" action="/index.php/hiwall/new_hipost" class="form_style1">
            <textarea name="hipost" required="required" placeholder="Hipost (max 300 characters)"></textarea>
            <input type="submit" name="comment_action" value="Post" class="btn_style1"/>
        </form>
    </div>
</div>
