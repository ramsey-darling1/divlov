

    
<div id="blog">
    <h3 class="txt_style1">Blog</h3>
    <br />
    <?php if(isset($blogger_name)):?>
        <h4><?php echo $blogger_name; ?>'s posts</h4>
    <?php else:?>
        <p><a class="btn_style1 pad" id="opener">New Post</a></p>
    <?php endif;?>
    <br />
    <div id="posts_wrap" class="list_style2">
            <ul>
                <?php
                    if(isset($posts) and !empty($posts)){
                        
                        foreach($posts as $post){
                            echo '<li class="post link_style2">';
                            echo '<ul class="brick">';
                            echo '<li class="date_post_posted">'.date('m/d/y',$post->date_posted).'</li>';//take the timestamp and echo it as a friendly, readable date
                            echo '<li class="post_title"><a href="/index.php/blog/read_blog/'.$post->bid.'">'.htmlspecialchars($post->post_title).'</a></li>';
                            echo '<li class="post_body"><a href="/index.php/blog/read_blog/'.$post->bid.'">'.htmlspecialchars($post->blog_post).'</a></li>';
                            if(isset($post->comments_id)){
                                if($post->comments_id != ''){
                                    echo '<li><a href="/index.php/blog/read_blog/'.$post->bid.'">view comments</a></li>';
                                }
                            }
                            echo '</ul>';
                            echo '</li>';
                        }
                    }else{
                        echo "<li>There are no posts available</li";
                    }
                ?>
               
            </ul>
    </div>
</div>

<!-- hidden compose form-->
<div class="dialog">
    <div class="new_message_wrap">
        <h3 class="txt_style2">New Post</h3>
        <form name="new_post" method="post" action="/index.php/blog/new_post" class="form_style1">
            <input name="title" type="text" placeholder="title"/>
            <textarea name="post" required="required" placeholder="post"></textarea>
            <input type="submit" name="comment_action" value="Post" class="btn_style1 btn"/>
        </form>
    </div>
</div>
