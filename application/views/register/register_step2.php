
<div id="signup">
    <div class="">	
	<p><strong>The DivLov community is excited to be getting a new member</strong></p>
	
	<p>Please tell us a little more about yourself, like how old you are and where you live, and what gender definition 
		you use. The DivLov community is totally accepting and tolerant of all the different and wonderful ways 
		people define their gender and sexuality. Signing up as a couple? That's fine too.</p>
    </div>
<div class="">
    <form method="post" action="/index.php/users/reg_step_3" class="form_style1">
		<select name="orientation" required>
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
	    <select name="relationship_status" required>
			<option value="">relationship status</option>
			<option value="single">single</option>
			<option value="casual">casual dating</option>
			<option value="serious">serious dating</option>
			<option value="married">married</option>
			<option value="poly">poly</option>
			<option value="open">open</option>
            <option value="other">other</option>
	    </select>
       <select name="age" required>
			<option>age</option>
			<?php 
				$age = 18;
				while($age <= 99){
					echo "<option value='{$age}'>{$age}</option>";
					$age = $age + 1;
				}
			?>
		</select>
		<input type="text" name="state" placeholder="state (MI)" maxlength="2" required />
		<input type="text" name="city" placeholder="city" required />
		<select name="gender" required>
			<option value="">gender</option>
			<option value="male">male</option>
			<option value="female">female</option>
			<option value="tmtf">trans m to f</option>
			<option value="tftm">trans f to m</option>
			<option value="androgyne">androgyne</option>
			<option value="queer">queer</option>
			<option value="other">other</option>
		</select>
		<input type="checkbox" name="couple" id="couple_checkbox" /><label for="couple">signing up as a couple</label>
		<div class="brick"></div>
		<div class="dissapear" id="for_couples">
			<div>
				<!--for couples-->
				<select name="gender2">
					<option value="">partner's gender</option>
					<option value="male">male</option>
					<option value="female">female</option>
					<option value="tmtf">trans m to f</option>
					<option value="tftm">trans f to m</option>
					<option value="androgyne">androgyne</option>
					<option value="queer">queer</option>
					<option value="other">other</option>
				</select>
				<select name="orientation2">
					<option value="">partner's orientation</option>
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
				<select name="age2">
					<option>partner's age</option>
						<?php 
							$age2 = 18;
							while($age2 <= 99){
								echo "<option value='{$age2}'>{$age2}</option>";
								$age2 = $age2 + 1;
							}
						?>
				</select>
			</div>
		</div>
		<input type="submit" name="submit" value="continue" class="button btn_style1 m45"/>
    </form>
</div>
<div class="brick"></div>
</div>
				