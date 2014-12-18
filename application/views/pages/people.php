    
<div id="people">
    <?php if(isset($no_people_response)){echo $no_people_response;}?>
    <h3 class="txt_style1">People</h3>
   <?php if(isset($default_looking4)):?>
    
        <div id="looking_4" style="margin-bottom: 2rem;padding-bottom: 2rem;">
            <form action="/index.php/pages/people/custom" class="form_style2" method="post">
                <h4 class="txt_style1">What you are looking for:</h4>
    
                <select name="gender">
                    <option value="">seeking gender</option>
                    <option value="male" <?php if(@$default_looking4[0]->gender == 'male'){ print 'selected'; }?>>males</option>
                    <option value="female" <?php if(@$default_looking4[0]->gender == 'female'){ print 'selected'; }?>>females</option>
                    <option value="malesandfemales" <?php if(@$default_looking4[0]->gender == 'malesandfemales'){ print 'selected'; }?>>males and females</option>
                    <option value="transmtof" <?php if(@$default_looking4[0]->gender == 'transmtof'){ print 'selected'; }?>>trans m to f</option>
                    <option value="transftom" <?php if(@$default_looking4[0]->gender == 'transftom'){ print 'selected'; }?>>trans f to m</option>
                    <option value="androgyne" <?php if(@$default_looking4[0]->gender == 'androgyne'){ print 'selected'; }?>>androgyne</option>
                    <option value="everyone" <?php if(@$default_looking4[0]->gender == 'everyone'){ print 'selected'; }?>>everyone</option>
                    <option value="couple" <?php if(@$default_looking4[0]->gender == 'couple'){ print 'selected'; }?>>a couple</option>
                    <option value="nomatter" <?php if(@$default_looking4[0]->gender == 'nomatter'){ print 'selected'; }?>>gender doesn't matter</option>
                    <option value="other" <?php if(@$default_looking4[0]->gender == 'other'){ print 'selected'; }?>>other</option>
                </select>
                
                <select name="orientation">
                    <option value="">seeking orientation</option>
                    <option value="straight" <?php if(@$default_looking4[0]->orientation == 'straight'){ print 'selected'; }?>>straight</option>
                    <option value="gay" <?php if(@$default_looking4[0]->orientation == 'gay'){ print 'selected'; }?>>gay</option>
                    <option value="lesbian" <?php if(@$default_looking4[0]->orientation == 'lesbian'){ print 'selected'; }?>>lesbian</option>
                    <option value="bi" <?php if(@$default_looking4[0]->orientation == 'bi'){ print 'selected'; }?>>bi</option>
                    <option value="pansexual" <?php if(@$default_looking4[0]->orientation == 'pansexual'){ print 'selected'; }?>>pansexual</option>
                    <option value="transgender" <?php if(@$default_looking4[0]->orientation == 'transgender'){ print 'selected'; }?>>transgender</option>
                    <option value="queer" <?php if(@$default_looking4[0]->orientation == 'queer'){ print 'selected'; }?>>queer</option>
                    <option value="other" <?php if(@$default_looking4[0]->orientation == 'other'){ print 'selected'; }?>>other</option>
                    <option value="nomatter" <?php if(@$default_looking4[0]->orientation == 'nomatter'){ print 'selected'; }?>>does not matter</option>
                </select>
                
               <select name="age">
                    <option>seeking ages</option>
                    <?php 
                        $age = 18;
                        while($age <= 99){
                            
                            $age == @$default_looking4[0]->age ? $sel = 'selected' : $sel = null;
                            
                            echo "<option value='{$age}' {$sel}>{$age}</option>";
                            $age = $age + 1;
                        }
                    ?>
                </select>
               
                <select name="age2" required>
                    <option>to</option>
                    <?php 
                        $age = 18;
                        while($age <= 99){
                            
                            $age == @$default_looking4[0]->age2 ? $sel = 'selected' : $sel = null;
                            
                            echo "<option value='{$age}'>{$age}</option>";
                            $age = $age + 1;
                        }
                    ?>
                </select>
                
                <select name="status">
                    <option value="">desired status</option>
                    <option value="single" <?php if(@$default_looking4[0]->status == 'single'){ print 'selected'; }?>>single</option>
                    <option value="dating" <?php if(@$default_looking4[0]->status == 'dating'){ print 'selected'; }?>>dating</option>
                    <option value="married" <?php if(@$default_looking4[0]->status == 'married'){ print 'selected'; }?>>married</option>
                    <option value="poly" <?php if(@$default_looking4[0]->status == 'poly'){ print 'selected'; }?>>poly</option>
                    <option value="other" <?php if(@$default_looking4[0]->status == 'other'){ print 'selected'; }?>>other</option>
                    <option value="nomatter" <?php if(@$default_looking4[0]->status == 'nomatter'){ print 'selected'; }?>>doesn't matter</option>
                </select>
                
                <select name="for">
                    <option value="">for</option>
                    <option value="longterm" <?php if(@$default_looking4[0]->looking_for == 'longterm'){ print 'selected'; }?>>long term</option>
                    <option value="shortterm" <?php if(@$default_looking4[0]->looking_for == 'shortterm'){ print 'selected'; }?>>casual</option>
                    <option value="hookup" <?php if(@$default_looking4[0]->looking_for == 'hookup'){ print 'selected'; }?>>hookup</option>
                    <option value="friends" <?php if(@$default_looking4[0]->looking_for == 'friends'){ print 'selected'; }?>>friends</option>
                    <option value="fwb" <?php if(@$default_looking4[0]->looking_for == 'fwb'){ print 'selected'; }?>>fwb</option>
                    <option value="dating" <?php if(@$default_looking4[0]->looking_for == 'dating'){ print 'selected'; }?>>dating</option>
                    <option value="poly" <?php if(@$default_looking4[0]->looking_for == 'poly'){ print 'selected'; }?>>poly relationship</option>
                    <option value="open" <?php if(@$default_looking4[0]->looking_for == 'open'){ print 'selected'; }?>>open relationship</option>
                    <option value="other">other</option>
                    <option value="nomatter">let's see what happens</option>
                </select>
                
                <select name="alternatives">
                    <option value="">I am also into...</option>
                    <option value="threesomes" <?php if(@$default_looking4[0]->alternatives == 'threesomes'){ print 'selected'; }?>>threesomes</option>
                    <option value="couples" <?php if(@$default_looking4[0]->alternatives == 'couples'){ print 'selected'; }?>>couples</option>
                    <option value="groupplay" <?php if(@$default_looking4[0]->alternatives == 'groupplay'){ print 'selected'; }?>>group play</option>
                    <option value="roleplaying" <?php if(@$default_looking4[0]->alternatives == 'roleplaying'){ print 'selected'; }?>>role playing</option>
                    <option value="bondage" <?php if(@$default_looking4[0]->alternatives == 'bondage'){ print 'selected'; }?>>bondage</option>
                    <option value="other" <?php if(@$default_looking4[0]->alternatives == 'other'){ print 'selected'; }?>>other</option>
                    <option value="normal" <?php if(@$default_looking4[0]->alternatives == 'normal'){ print 'selected'; }?>>just 'normal' stuff</option>
                    <option value="none" <?php if(@$default_looking4[0]->alternatives == 'none'){ print 'selected'; }?>>none of the above</option>
                </select>
                
                <input type="submit" name="submit" value="search" class="button btn_style1"/>
            </form>
            <div class="brick"></div>
        </div>
   <?php endif;?>
    
            <ul class="brick">
                <?php
                    //display all the people that the current user might be interested in
                    if(isset($all_people)){
                        /*echo "<pre>";
                        print_r($all_people);die;*/
                        if(!empty($all_people)){
                            foreach($all_people as $person){
                               /* echo "<pre>";
                                var_dump($person);
                                echo "<br /><h1>END</h1><br />";*/
                                if(isset($person['p_username'])){
                                    //makes sure it's not a blank result
                                    if($person['p_username'] != @$username){
                                        //makes sure that we don't show a user their own result
                                        echo '<li class="link_style2 people_pod">';
                                        echo '<ul class="inline">';
                                        if(!empty($person['p_profile_pic'])){
                                            //if the person has a profile pic, display that here
                                            if($person['p_profile_pic'][0]->image_type == 'jpeg'){
                                                //change jpeg to jpg so it can be used in the file path
                                                $person['p_profile_pic'][0]->image_type = 'jpg';
                                            }
                                            echo '<li class="persons_pic"><a href="/index.php/pages/profile/'.$person['p_username'].'"><img src="/assets/userimages/'.$person['p_profile_pic'][0]->raw_name.'.'.$person['p_profile_pic'][0]->image_type.'" alt="profile pic" style="max-width:160px;" /></a></li>';
                                        }else{
                                            echo '<li class="persons_pic"><a href="/index.php/pages/profile/'.$person['p_username'].'"><img src="/assets/images/profilepic.jpg" alt="default pic" /></a></li>';    
                                        }
                                        echo '<li class="persons_username"><a href="/index.php/pages/profile/'.$person['p_username'].'"> '.$person['p_username'].'</a></li>';                                        
                                        echo '<li class="persons_details">'.$person["p_details"][0]->relationship_status.' / '.$person["p_details"][0]->orientation.' / '.$person["p_details"][0]->age.' / '.$person["p_details"][0]->gender.' / '.$person["p_details"][0]->city.', '.$person["p_details"][0]->state.'</li>';
                                        if(!empty($person['couple'])){
                                            echo '<li style="left:10px;">'.$person['couple'][0]->gender.' | '.$person['couple'][0]->orientation.' | '.$person['couple'][0]->age.'</li>';
                                        }
                                        echo '<li class="visit_person_button"><a href="/index.php/pages/profile/'.$person['p_username'].'" class="btn_style2">Visit Profile</a></li>';
                                        echo '</ul>';
                                        echo '</li>';
                                    }
                                    
                                }
                            }
                            
                        }else{
                            echo '<li><h2>Sorry, we can not seem to find anybody right now. If the problem continues, try expanding your search.</h2></li>';    
                        }
                    }else{
                        echo '<li><h2>Sorry, we can not seem to find anybody right now. Please try later.</h2></li>';
                    }
                ?>
              
            </ul>
    
</div>
