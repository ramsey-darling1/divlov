
<div id="signup">
    <div class="">	
	<p><strong>Last Step</strong></p>
	<p>Here is your chance to define what it is you hope to discover on DivLov. We try to be as accommodating as 
		possible to the vast spectrum of relationship styles and approaches. Whatever it is that you are looking for, 
		be it a serious life long relationship, or a short lived fling, or anything in between, you can find it on 
		DivLov.</p>
    </div>
<div class="">
    
    <form method="post" action="/index.php/users/save_last_step" class="form_style1">
		<select name="seekinggender" required>
			<option value="">seeking gender</option>
			<option value="male">males</option>
			<option value="female">females</option>
			<option value="malesandfemales">males and females</option>
			<option value="transmtof">trans m to f</option>
			<option value="transftom">trans f to m</option>
			<option value="androgyne">androgyne</option>
			<option value="everyone">everyone</option>
			<option value="couple">a couple</option>
			<option value="nomatter">gender doesn't matter</option>
			<option value="other">other</option>
		</select>
		<select name="seekingorientation" required>
			<option value="">seeking orientation</option>
			<option value="straight">straight</option>
			<option value="gay">gay</option>
			<option value="lesbian">lesbian</option>
			<option value="bi">bi</option>
			<option value="pansexual">pansexual</option>
			<option value="transgender">transgender</option>
			<option value="queer">queer</option>
			<option value="other">other</option>
			<option value="nomatter">does not matter</option>
		</select>
       <select name="seekingage" required>
			<option>seeking ages</option>
			<?php 
				$age = 18;
				while($age <= 99){
					echo "<option value='{$age}'>{$age}</option>";
					$age = $age + 1;
				}
			?>
		</select>
	    <select name="seekingage2" required>
			<option>to</option>
			<?php 
				$age = 18;
				while($age <= 99){
					echo "<option value='{$age}'>{$age}</option>";
					$age = $age + 1;
				}
			?>
		</select>
		<select name="seekingstatus" required>
			<option value="">desired status</option>
			<option value="single">single</option>
			<option value="dating">dating</option>
			<option value="married">married</option>
			<option value="poly">poly</option>
			<option value="other">other</option>
			<option value="nomatter">doesn't matter</option>
		</select>
		<select name="for" required>
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
		
		<input type="submit" name="submit" value="continue" class="button btn_style1 m45"/>
    </form>
</div>
<div class="brick"></div>
</div>