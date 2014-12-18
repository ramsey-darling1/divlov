<div id="take_hitest">
   <h2><?php echo @$hitest_name; ?>'s Test</h2>
   <br />
   <form method="post" action="/index.php/hitest/calc_hitest/" class="form_style1">
        <input type="hidden" name="hitest_owner" value="<?php echo @$hitest_owner; ?>" />
        <?php
            if(isset($hitest)){
            
                if(!empty($hitest)){
                    $c = 1;
                    foreach($hitest as $ht){
                        echo $c.'. '.htmlspecialchars($ht->question);
                        echo '<select name="'.$ht->qid.'">';
                        echo '<option value="1">'.$ht->ans1.'</option>';
                        echo '<option value="2">'.$ht->ans2.'</option>';
                        echo '<option value="3">'.$ht->ans3.'</option>';
                        echo '<option value="4">'.$ht->ans4.'</option>';
                        echo '</select>';
                        echo '<br />';
                        $c = $c + 1;
                    }
                    
                    echo '<input type="submit" value="Submit Hitest" class="btn_style1" />';
                }
            }
        ?>
   </form>
</div>
