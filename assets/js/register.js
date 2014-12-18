/**
 *JS for Registration Views
 *@rdarling
 *
 */

$(document).ready(function(){
    
    $('input[name="username"]').blur(function(){
        
        var response;
        
        var message_type;
        
        var username = $(this).val();
        
        if (username == '') {
            response = 'Username can not be blank';
            message_type = 'error';
        }else if (username.length < 6) {
            response = 'Username must be at least 6 characters long';
            message_type = 'error';
        }else if (username.search('@') > -1) {
            response = 'Username can not be an email address or contain the @ character';
            message_type = 'error';
        }else if (username.search(' ') > -1) {
            response = 'Username can not contain blank spaces';
            message_type = 'error';
        }else{
            response = 'Username looks good so far';
            message_type = 'success';
        }
        
        if (message_type == 'error') {
            $(this).addClass('error');
        }else{
            $(this).removeClass('error');
        }
        
        $('#reg_response').html('<div class="'+message_type+'">'+response+'</div>');
    
    });
    
    $('input[name="email"]').blur(function(){
        
        var response;
        
        var message_type;
        
        var email = $(this).val();
        
        if (email == '') {
            response = 'Email can not be blank';
            message_type = 'error';
        }else if (email.length < 5) {
            response = 'Email must be at least 5 characters long';
            message_type = 'error';
        }else if (email.search('@') == -1) {
            response = 'That is not a valid email address';
            message_type = 'error';
        }else if (email.search('.') == -1) {
            response = 'That does not seem like a valid email address';
            message_type = 'error';
        }else{
            response = 'Email looks good so far';
            message_type = 'success';
        }
        
        if (message_type == 'error') {
            $(this).addClass('error');
        }else{
            $(this).removeClass('error');
        }
        
        $('#reg_response').html('<div class="'+message_type+'">'+response+'</div>');
    
    });
    
    $('input[name="password"]').blur(function(){
        
        var response;
        
        var message_type;
        
        var password = $(this).val();
        
        if (password == '') {
            response = 'Password can not be blank';
            message_type = 'error';
        }else if (password.length < 8) {
            response = 'Password must be at least 8 characters long';
            message_type = 'error';
        }else{
            response = 'Password looks good';
            message_type = 'success';
        }
        
        if (message_type == 'error') {
            $(this).addClass('error');
        }else{
            $(this).removeClass('error');
        }
        
        $('#reg_response').html('<div class="'+message_type+'">'+response+'</div>');
    
    });
    
});