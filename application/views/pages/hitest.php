

    
<div id="hitest">
    <h3 class="txt_style1">Design Your Custom Test</h3>
    <br />
    <p><a class="btn_style1 pad" id="opener">New Question</a></p>
    <br />
    <div id="test_wrap" class="list_style2">
        
        <?php
            if(isset($questions)){
                if(!empty($questions)){
                    $count = 1;
                    foreach($questions as $quest){
                        echo '<div class="question">';
                        echo '<h4 class="txt_style1">Question '.$count.'</h4>';
                        echo '<form method="post" action="/index.php/hitest/update" class="form_style1">';
                            echo '<label for="question">Question: </label><textarea name="question" required="required" placeholder="question" readonly >'.$quest->question.'</textarea>';
                            echo '<label for="ans1">Answer 1: </label><input name="ans1" type="text" required="required" placeholder="Answer 1" readonly value="'.$quest->ans1.'" />';
                            echo '<label for="ans2">Answer 2: </label><input name="ans2" type="text" required="required" placeholder="Answer 1" readonly value="'.$quest->ans2.'" />';
                            echo '<label for="ans3">Answer 3: </label><input name="ans3" type="text" required="required" placeholder="Answer 1" readonly value="'.$quest->ans3.'" />';
                            echo '<label for="ans4">Answer 4: </label><input name="ans4" type="text" required="required" placeholder="Answer 1" readonly value="'.$quest->ans4.'" />';
                            echo '<label for="correct_ans">Correct Answer: </label><input name="correct_ans" required readonly max="4" value="'.$quest->correct_ans.'"/>';
                            echo '<input type="button" value="Delete Question" class="btn_style1 delete_quest"/>';
                            echo '<input type="button" value="Edit Question" class="btn_style1 edit_quest"/>';
                        echo '</form>';
                        //here is where there will be information about who answered the question. 
                        echo '</div>';
                        $count = $count + 1;
                    }
                }else{
                    echo "<p>It doesn't seem like you have added any questions to your test yet. The test is your own customizable test that you create, for other people to fill out. </p>
                        <p>What are you actually interested in knowing about other people? This is your opportunity to find out. Ask anything you like, create four possible answers, and choose which is the right one. </p>";
                }
            }else{
                echo "<p>You have no questions yet. Please add some.</p>";
            }
        ?>
    </div>
</div>

<!-- hidden compose form-->
<div class="dialog">
    <div class="new_comment_wrap">
        <h3 class="txt_style2">New Question</h3>
        <form name="new_post" method="post" action="/index.php/hitest/add_question" class="form_style1">
            <textarea name="question" required="required" placeholder="question"></textarea>
            <input name="ans1" type="text" required="required" placeholder="Answer 1"/>
            <input name="ans2" type="text" required="required" placeholder="Answer 2"/>
            <input name="ans3" type="text" required="required" placeholder="Answer 3"/>
            <input name="ans4" type="text" required="required" placeholder="Answer 4"/>
            <select name="correct_ans" required="required">
                <option>Correct Answer</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <input type="submit" value="Add Question" class="btn_style1"/>
        </form>
    </div>
</div>
