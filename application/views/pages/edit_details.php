<div id="edit_details_page" class="form_style1">
    <h3 class="txt_style1">Edit Your Personal Details</h3>
    <br />
    <form method="post" action="">
        <h4 class="txt_style1">My Bio</h4>
        <textarea name="bio" placeholder="Your bio"></textarea>
        <br />
        <h4 class="txt_style1">My Interests</h4>
        <textarea name="interests" placeholder="Share some of your interestes"></textarea>
        <br />
        <h4 class="txt_style1">What I am looking for</h4>
        <select name="seekinggender">
			<option value="">seeking gender</option>
			<option value="male">males</option>
			<option value="female">females</option>
			<option value="malesandfemales">males and females</option>
			<option value="transmtof">trans m to f</option>
			<option value="transftom">trans f to m</option>
			<option value="transftom">androgyne</option>
			<option value="everyone">everyone</option>
			<option value="couple">a couple</option>
			<option value="nomatter">gender doesn't matter</option>
			<option value="other">other</option>
		</select>
		<select name="seekingorientation">
			<option value="">seeking orientation</option>
			<option value="straight">straight</option>
			<option value="gay">gay</option>
			<option value="lesbian">lesbian</option>
			<option value="bi">bi</option>
			<option value="transgender">transgender</option>
			<option value="queer">queer</option>
			<option value="other">other</option>
			<option value="nomatter">does not matter</option>
		</select>
       <select name="seekingage">
			<option>seeking ages</option>
			<?php 
				$age = 18;
				while($age <= 99){
					echo "<option value='{$age}'>{$age}</option>";
					$age = $age + 1;
				}
			?>
		</select>
	    <select name="seekingage2">
			<option>to</option>
			<?php 
				$age2 = 18;
				while($age2 <= 99){
					echo "<option value='{$age2}'>{$age2}</option>";
					$age2 = $age2 + 1;
				}
			?>
		</select>
		<select name="seekingstatus">
			<option value="">desired status</option>
			<option value="single">single</option>
			<option value="dating">dating</option>
			<option value="married">married</option>
			<option value="poly">poly</option>
			<option value="other">other</option>
			<option value="nomatter">doesn't matter</option>
		</select>
		<select name="for">
			<option value="">for</option>
			<option value="longterm">long term</option>
			<option value="shortterm">casual</option>
			<option value="hookup">hookup</option>
			<option value="friends">friends</option>
			<option value="fwb">fwb</option>
			<option value="dating">dating</option>
			<option value="poly">poly relationship</option>
			<option value="open">open relationship</option>
			<option value="other">other</option>
			<option value="nomatter">let's see what happens</option>
		</select>
		<select name="alternatives">
			<option value="">I am also into...</option>
			<option value="threesomes">threesomes</option>
			<option value="couples">couples</option>
			<option value="groupplay">group play</option>
			<option value="roleplaying">role playing</option>
			<option value="bondage">bondage</option>
			<option value="other">other</option>
			<option value="normal">just 'normal' stuff</option>
			<option value="none">none of the above</option>
		</select>
        <br />
        <h4 class="txt_style1">About Me</h4>
        <select name="orientation">
			<option value="">orientation</option>
			<option value="straight">straight</option>
			<option value="gay">gay</option>
			<option value="lesbian">lesbian</option>
			<option value="bi">bi</option>
			<option value="transgender">transgender</option>
			<option value="queer">queer</option>
			<option value="pansexual">pansexual</option>
			<option value="open">open</option>
            <option value="other">other</option>
	    </select>
	    <select name="relationship_status">
			<option value="">relationship status</option>
			<option value="single">single</option>
			<option value="casual">casual dating</option>
			<option value="serious">serious dating</option>
			<option value="married">married</option>
			<option value="poly">poly</option>
			<option value="open">open</option>
            <option value="other">other</option>
	    </select>
       <select name="age">
			<option>age</option>
			<?php 
				$age = 18;
				while($age <= 99){
					echo "<option value='{$age}'>{$age}</option>";
					$age = $age + 1;
				}
			?>
		</select>
		<input type="text" name="state" placeholder="state (MI)" maxlength="2" />
		<input type="text" name="city" placeholder="city" />
		<select name="gender">
			<option value="">gender</option>
			<option value="male">male</option>
			<option value="female">female</option>
			<option value="tmtf">trans m to f</option>
			<option value="tmtf">trans f to m</option>
			<option value="androgyne">androgyne</option>
			<option value="queer">queer</option>
			<option value="other">other</option>
		</select>
		
		<div class="brick"></div>
		
    </form>
    
    
    
</div>
