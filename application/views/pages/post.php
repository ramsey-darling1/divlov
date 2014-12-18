

    
<div id="blog">
    <h3 class="txt_style1">Post - <?php if(isset($blog_post[0]->post_title)){echo htmlspecialchars($blog_post[0]->post_title);}?></h3>
    <br />
    <p><a class="btn_style1 pad" id="opener">Comment</a></p>
    <br />
    <div id="posts_wrap" class="list_style2">
            <ul>
                <?php
                    if(isset($blog_post) and !empty($blog_post)){
                        
                        echo '<li class="post link_style2">';
                        echo '<ul class="brick">';
                        echo '<li class="date_post_posted">'.date('m/d/y',$blog_post[0]->date_posted).'</li>';//take the timestamp and echo it as a friendly, readable date
                        echo '<li class="post_title">'.htmlspecialchars($blog_post[0]->post_title).'</li>';
                        echo '<li class="post_body">'.htmlspecialchars($blog_post[0]->blog_post).'</li>';
                            //echo '<li class="comment_form"><form action="" method="post"><input type="hidden" name="post_id" value="'.$post->bid.'"/><input type="submit" value="Comment" class="btn_style2" /></form></li>';
                        echo '</ul>';
                        echo '</li>';
                       
                    }else{
                        echo "<li>There is no post available</li";
                    }
                ?>
               
            </ul>
            <?php
                if(isset($comments)){
                    if(!empty($comments)){
                        //we have comments. display them
                        foreach($comments as $comment){
                            echo '<ul>';
                                echo '<li class="post link_style2 comment">';
                                    echo '<ul class="brick">';
                                    echo '<li class="date_post_posted">'.date('m/d/y',$comment->date_commented).'</li>';//take the timestamp and echo it as a friendly, readable date
                                    echo '<li class="post_title"><a href="/index.php/pages/profile/'.@$c_username.'">';
                                    echo @htmlspecialchars($c_username).'</a></li>';
                                    echo '<li class="post_body">'.htmlspecialchars($comment->comment).'</li>';
                                    echo '</ul>';
                                echo '</li>';
                            echo '</ul>';
                        }
                        
                    }
                }
            ?>
    </div>
</div>

<!-- hidden compose form-->
<div class="dialog">
    <div class="new_comment_wrap">
        <h3 class="txt_style2">New Comment</h3>
        <form name="new_post" method="post" action="/index.php/blog/comment" class="form_style1">
            <textarea name="comment" required="required" placeholder="comment"></textarea>
            <input type="hidden" name="comments_id" value="<?php if(isset($comments)){echo @$comments[0]->comments_id;}?>" />
            <input type="hidden" name="blog_id" value="<?php if(isset($blog_post)){echo @$blog_post[0]->bid;}?>" />
            <input type="submit" name="comment_action" value="Post" class="btn_style1"/>
        </form>
    </div>
</div>
