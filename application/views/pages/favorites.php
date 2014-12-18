<div id="rem_fav_response"></div>
<div id="people">
    <h3 class="txt_style1">Your Favorites</h3>
    <br />
            <ul>
                <?php
                    //display all the people that the current user might be interested in
                    if(isset($all_favs)){
                        if(!empty($all_favs)){
                            foreach($all_favs as $fav){
                                if(isset($fav['fid'])){
                                    //makes sure it's not a blank result
                                        echo '<li class="link_style2 people_pod" id="fav_'.$fav["fid"].'">';
                                        echo '<ul class="inline">';
                                        if(!empty($fav['profile_pic'])){
                                                //if the person has a profile pic, display that here
                                                if($fav['profile_pic'][0]->image_type == 'jpeg'){
                                                //change jpeg to jpg so it can be used in the file path
                                                  $fav['profile_pic'][0]->image_type = 'jpg';
                                                }
                                            echo '<li class="persons_pic"><a href="/index.php/pages/profile/'.$fav['fav_username'].'"><img src="/assets/userimages/'.$fav['profile_pic'][0]->raw_name.'.'.$fav['profile_pic'][0]->image_type.'" alt="profile pic" style="max-width:160px;" /></a></li>';
                                        }else{
                                            echo '<li class="persons_pic"><a href="/index.php/pages/profile/'.$fav['fav_username'].'"><img src="/assets/images/profilepic.jpg" alt="default pic" /></a></li>';    
                                        }
                                        echo '<li class="persons_username"><a href="/index.php/pages/profile/'.$fav['fav_username'].'"> '.$fav['fav_username'].'</a></li>';
                                        echo '<li class="persons_details">'.$fav["details"][0]->relationship_status.' / '.$fav["details"][0]->orientation.' / '.$fav["details"][0]->age.' / '.$fav["details"][0]->gender.' / '.$fav["details"][0]->city.', '.$fav["details"][0]->state.'</li>';
                                        echo '<li class="visit_person_button"><a href="/index.php/pages/profile/'.$fav['fav_username'].'" class="btn_style2">Visit Profile</a> <a href="/index.php/favorites/remove/'.$fav['fid'].'" class="btn_style2 fav_rem_butt">Remove Favorite</a></li>';
                                        
                                        echo '</ul>';
                                        echo '</li>';
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
<script type="text/javascript" src="/assets/js/favorite.js"></script>
