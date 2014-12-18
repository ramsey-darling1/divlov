<div id="read_message">
    <h3 class="txt_style1">Messaging</h3>
    <p class="txt_style2"><?php if(isset($mess)){ echo htmlspecialchars($mess[0]->message_subject);}?></p>
    <div class='message_body'>
        <p><?php if(isset($mess)){echo htmlspecialchars($mess[0]->message);}?></p>
    </div>
    <div class="message_data">
        <p class="link_style2">from:
                <?php
                    if(isset($mess)){
                        $from_username = $mod->re_username($mess[0]->from_id);
                        echo '<a href="/index.php/pages/profile/'.$from_username.'">'.$from_username.'</a>';
                    }
                ?>
        </p>
        <p>date sent: <?php if(isset($mess)){ echo date('m/d/y',$mess[0]->date_sent);}?></p>
    </div>
    <div class="message_action">
        <ul class="inline right">
            <li><a id="opener" class="btn_style1 pad">reply</a></li>
            
            <li>
                <form action="/index.php/messaging/delete_messages" method="post">
                    <input type="hidden" name="mess_del" value="<?php if(isset($mess)){echo $mess[0]->mid;}?>" />
                    <input type="submit" value="delete" class="btn_style1 pad"/>
                </form>
            </li>
        </ul>
    </div>
</div>

<!-- hidden compose form-->
<div class="dialog">
    <div class="new_message_wrap">
        <h3 class="txt_style2">Compose</h3>
        <form name="new_message" method="post" action="/index.php/messaging/send_message" class="form_style1">
            <input name="to" type="text" required="required" placeholder="to" value="<?php if(isset($mess)){
                                                                                                $from_username = $mod->re_username($mess[0]->from_id);
                                                                                                echo $from_username;
                                                                                            }
                                                                                     ?>" />
            <input name="subject" type="text" placeholder="subject" value="re:<?php if(isset($mess)){echo $mess[0]->message_subject;}?>"/>
            <textarea name="message" required="required" placeholder="message"></textarea>
            <input type="submit" name="new_message_action" value="Send Message" class="btn_style1"/>
            <input type="hidden" name="re_des" value="/index.php/pages/messaging"/>
        </form>
    </div>
</div>