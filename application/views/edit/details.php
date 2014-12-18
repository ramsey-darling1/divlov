<div id="edit_details">
    <h2>Edit Details</h2>
    <br />
    <form action="/index.php/profile/edit_details_action" method="post" class="form_style1">
        <select name="orientation" required>
	    <option value="">orientation</option>
	    <option value="straight" <?php @$details[0]->orientation == 'straight' ? print 'selected' : null; ?>>straight</option>
	    <option value="gay" <?php @$details[0]->orientation == 'gay' ? print 'selected' : null; ?>>gay</option>
	    <option value="lesbian" <?php @$details[0]->orientation == 'lesbian' ? print 'selected' : null; ?>>lesbian</option>
	    <option value="bi" <?php @$details[0]->orientation == 'bi' ? print 'selected' : null; ?>>bi</option>
	    <option value="transgender" <?php @$details[0]->orientation == 'transgender' ? print 'selected' : null; ?>>transgender</option>
	    <option value="queer" <?php @$details[0]->orientation == 'queer' ? print 'selected' : null; ?>>queer</option>
	    <option value="pansexual" <?php @$details[0]->orientation == 'pansexual' ? print 'selected' : null; ?>>pansexual</option>
	    <option value="open" <?php @$details[0]->orientation == 'open' ? print 'selected' : null; ?>>open</option>
            <option value="other" <?php @$details[0]->orientation == 'other' ? print 'selected' : null; ?>>other</option>
	</select>
	<select name="relationship_status" required>
	    <option value="">relationship status</option>
	    <option value="single" <?php @$details[0]->relationship_status == 'single' ? print 'selected' : null; ?>>single</option>
	    <option value="casual" <?php @$details[0]->relationship_status == 'casual' ? print 'selected' : null; ?>>casual dating</option>
	    <option value="serious" <?php @$details[0]->relationship_status == 'serious' ? print 'selected' : null; ?>>serious dating</option>
	    <option value="married" <?php @$details[0]->relationship_status == 'married' ? print 'selected' : null; ?>>married</option>
	    <option value="poly" <?php @$details[0]->relationship_status == 'poly' ? print 'selected' : null; ?>>poly</option>
	    <option value="open" <?php @$details[0]->relationship_status == 'open' ? print 'selected' : null; ?>>open</option>
            <option value="other" <?php @$details[0]->relationship_status == 'other' ? print 'selected' : null; ?>>other</option>
	</select>
       <select name="age" required>
            <option>age</option>
            <?php 
                $age = 18;
                while($age <= 99){
                    echo '<option value="'.$age.'"';
                    @$details[0]->age == $age ? print 'selected >' : print '>'; 
                    echo $age.'</option>';
                    $age = $age + 1;
                }
            ?>
	</select>
	<input type="text" name="state" placeholder="state (MI)" maxlength="2" required <?php !empty($details[0]->state) ? print 'value="'.$details[0]->state.'"' : null; ?> />
	<input type="text" name="city" placeholder="city" required <?php !empty($details[0]->city) ? print 'value="'.$details[0]->city.'"' : null; ?> />
        <select name="gender" required>
                <option value="">gender</option>
                <option value="male" <?php @$details[0]->gender == 'male' ? print 'selected' : null; ?>>male</option>
                <option value="female" <?php @$details[0]->gender == 'female' ? print 'selected' : null; ?>>female</option>
                <option value="tmtf" <?php @$details[0]->gender == 'tmtf' ? print 'selected' : null; ?>>trans m to f</option>
                <option value="tftm" <?php @$details[0]->gender == 'tftm' ? print 'selected' : null; ?>>trans f to m</option>
                <option value="androgyne" <?php @$details[0]->gender == 'androgyne' ? print 'selected' : null; ?>>androgyne</option>
                <option value="queer" <?php @$details[0]->gender == 'queer' ? print 'selected' : null; ?>>queer</option>
                <option value="other" <?php @$details[0]->gender == 'other' ? print 'selected' : null; ?>>other</option>
        </select>
        <input type="hidden" name="edit_details" value="1" />
        <input type="submit" value="update details" class="btn_style1" />
    </form>
</div>