/**
*This is the file to provide the javascript for the add to favorites functionality
*we are using jquery
*@rdarling
**/


jQuery(document).ready(function($){
    $("#fav_trig").click(function(){
        //grab the username that we are adding to the favorites
        var fav_user = $(this).attr("href").substring('/index.php/favorites/add/'.length);
        //alert(fav_user);
        
        $.ajax({
            url: '/index.php/favorites/add',
            type: 'POST',
            data: {fav_user: fav_user},
            success: function(re_msg){
                $('#add_fav_response').html(re_msg);
                //alert(re_msg);
            }
        });
        return false;//this prevents the a tag from linking anywhere
    });
});


jQuery(document).ready(function($){
    $(".fav_rem_butt").click(function(){
        //grab the username that we are adding to the favorites
        var fid = $(this).attr("href").substring('/index.php/favorites/remove/'.length);
        //alert(fav_user);
        var rem_id = '#fav_'+fid;
        $.ajax({
            url: '/index.php/favorites/remove',
            type: 'POST',
            data: {fid: fid},
            success: function(re_msg){
                $(rem_id).fadeOut();
                $('#rem_fav_response').html(re_msg);
                //alert(re_msg);
            }
        });
        return false;//this prevents the a tag from linking anywhere
    });
});

