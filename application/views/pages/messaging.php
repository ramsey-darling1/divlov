

    
<div id="messaging">
    <h3 class="txt_style1">Messaging</h3>
    <p>Inbox</p>
    <div id="inbox" class="list_style1">
        <form method="post" action="/index.php/messaging/delete_messages">
            <ul>
                <?php
                    if(isset($messages) and !empty($messages)){
                        
                        foreach($messages as $message){
                            echo '<li class="message';
                            if($message->unread == 1){
                                echo ' new">';
                            }else{
                                echo ' read">';
                            }
                            echo '<ul class="inline brick">';
                            echo '<li class="date_message_sent">'.date('m/d/y',$message->date_sent).'</li>';//take the timestamp and echo it as a friendly, readable date
                            echo '<li class="message_title"><a href="/index.php/messaging/read_message/'.$message->mid.'">'.htmlspecialchars($message->message_subject).'</a></li>';
                            //grab the username from the from_id
                            //$this->load->model('User_model','mod',true);
                            $from_username = $mod->re_username($message->from_id);
                            echo '<li class="message_from">'.$from_username.'</li>';//going to have to grab the username instead of the id
                            echo '<li class="reply_message"><a href="/index.php/messaging/read_message/'.$message->mid.'">read</a></li>';
                            echo '<li class="message_checkbox"><input type="checkbox" name="mess_del[]" value="'.$message->mid.'"/></li>';
                            echo '</ul>';
                            echo '</li>';
                        }
                    }else{
                        echo "<li>You have no messages</li";
                    }
                ?>
               
            </ul>
            <ul>
                <li>
                    <input type="button" value="Compose" name="new_message" id="opener" class="btn_style1" />
                    <input type="submit" value="Delete Checked" name="delete_checked" class="btn_style1" />
                </li>
            </ul>
        </form>
    </div>
</div>

<!-- hidden compose form-->
<div class="dialog">
    <div class="new_message_wrap">
        <h3 class="txt_style2">Compose</h3>
        <form name="new_message" method="post" action="/index.php/messaging/send_message" class="form_style1">
            <input name="to" type="text" required="required" placeholder="to" />
            <input name="subject" type="text" placeholder="subject"/>
            <textarea name="message" required="required" placeholder="message"></textarea>
            <input type="submit" name="new_message_action" value="Send Message" class="btn_style1"/>
            <input type="hidden" name="re_des" value="/index.php/pages/messaging"/>
        </form>
    </div>
</div>
