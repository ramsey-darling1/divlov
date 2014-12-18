<div id="edit_bio">
    <h2>Edit My Bio</h2>
    <p>Here you can update your bio that displays on your homepage. You are free to make it as long or short as you want.</p>
    <br />
    <form action="/index.php/profile/edit_bio_action" method="post" class="form_style1">
        <textarea name="bio" class="full_textarea"><?php if(isset($bio)){ echo @$bio[0]->bio;}?></textarea>
        <input type="submit" value="update bio" class="btn_style1" />
    </form>
</div>