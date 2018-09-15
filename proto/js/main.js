/**
 * Date: 2018/09/15 
 * Author: ASeryakov
 */
$(function(){
    var ajaxURL = '/ajax.php';
    /*AJAX global events*/
    $( document ).ajaxStart(function() {
        $('#wait-please').css('visibility','visible');
    });
    $( document ).ajaxComplete(function( event, request, settings ) {
        $('#wait-please').css('visibility','');
    });
    /*--------*/

    /*Auth event*/
    $('#loginform-button').click(function(){
        $("#login-message-block").removeClass("text-danger");
        $.post(ajaxURL, 
            {task: 'login', login: $('#loginform-username').val(), pwd: $('#loginform-password').val()}, 
            function(data){
                if( data.state == "error" ){
                    $("#login-message-block").addClass("text-danger").html(data.message);
                }else{
                    location.reload();
                }
            },
            'json');
        
    });
    
});