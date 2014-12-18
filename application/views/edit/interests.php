<div id="edit_bio">
    <h2>Edit My Interests</h2>
    <p>Here you can update your interests that display on your homepage. You are free to include as many things as you wish.</p>
    <br />
    <form action="/index.php/profile/edit_interests_action" method="post" class="form_style1">
        <textarea name="interests" class="full_textarea"><?php if(isset($interests)){ echo @$interests[0]->interests;}?></textarea>
        <input type="submit" value="update interests" class="btn_style1" />
    </form>
</div>