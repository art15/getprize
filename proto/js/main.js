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
    //TODO: при AJAX запросе деактивировать все кнопки и поля
    $('#loginform-button').click(function(){
        $("#login-message-block").removeClass("text-danger");
        $.post(ajaxURL, 
            {task: "login", login: $('#loginform-username').val(), pwd: $('#loginform-password').val()}, 
            function(data){
                if( data.state == "error" ){
                    $("#login-message-block").addClass("text-danger").html(data.message);
                }else{
                    location.reload();
                }
            },
            'json');
        
    });
    $('#logout-button').click(function(){
        $.post(ajaxURL, 
            {task: "logout" }, 
            function(data){
                location.reload();
            },
            'json');
        
    });
    /*--------*/
    
    /*Get random prize event*/
    $("#getprize").click(function(){
        $("#prize-result").empty();
        $.post(ajaxURL, 
            {task: "getPrize" }, 
            function(data){
                if(data.state == "success"){
                    $("#getprize").addClass("d-none");$("#declineprize").removeClass("d-none");
                    
                    setFields(data.data.prize);
                    if(data.data.prize.type == "bonus"){ //показываем цифру полученных уже на свой счет бонусов
                        var bonusAmount = parseInt($("#loyaltyBonus").val());
                        bonusAmount = bonusAmount + data.data.prize.randomAmount;
                        $("#loyaltyBonus").val(bonusAmount);
                        $("#bonusAmount").text(bonusAmount);
                    }
                    
                    if(data.data.prize.type == "money"){
                        $("#money-block").removeClass("d-none");
                    }
                    
                    if(data.data.prize.type == "material"){
                        $("#material-block").removeClass("d-none");
                    }
                }
                
                $("#prize-result").html(data.message);
            },
            'json');
    });
    
    /*Renounce the prize*/
    $("#declineprize").click(function(){
        $("#prize-result").empty();
        $("#money-block, #material-block").addClass("d-none");
        $.post(ajaxURL, 
            {task: "declinePrize"}, 
            function(data){
                if(data.state == "success"){
                    $("#declineprize").addClass("d-none");$("#getprize").removeClass("d-none");
                    
                    if($("#prize-type").val() == "bonus"){
                        var bonusAmount = parseInt($("#loyaltyBonus").val());
                        if(bonusAmount > 0){
                            //из общего бонуса вычитаем только что полученный
                            bonusAmount = bonusAmount - parseInt($("#prize-randomAmount").val());
                            $("#loyaltyBonus").val(bonusAmount);
                            $("#bonusAmount").text(bonusAmount);
                        }
                    }
                    cleanFields();
                }
                $("#prize-result").html(data.message);
            },
            'json');
    });
    
    /*transfer money to bank account*/
    $("#moneyToBankAccount").click(function(){
        $("#prize-result").empty();
        
        $.post(ajaxURL, 
            {task: "moneyToBankAccount"}, 
            function(data){
                if(data.state == "success"){
                    $("#money-block, #material-block").addClass("d-none");
                    $("#declineprize").addClass("d-none");$("#getprize").removeClass("d-none");
                    cleanFields();
                }
                $("#prize-result").html(data.message);
            },
            'json');
    });
    
    /*convert money to bonus*/
    $("#moneyConvertToBonus").click(function(){
        $("#prize-result").empty();
        
        $.post(ajaxURL, 
            {task: "moneyConvertToBonus"}, 
            function(data){
                if(data.state == "success"){
                    $("#money-block, #material-block").addClass("d-none");
                    $("#declineprize").addClass("d-none");$("#getprize").removeClass("d-none");
                    
                    
                    var bonusAmount = parseInt($("#loyaltyBonus").val());
                        bonusAmount = bonusAmount + data.data.bonusAmount;
                        $("#loyaltyBonus").val(bonusAmount)
                        $("#bonusAmount").text(bonusAmount);
                        
                    cleanFields();
                }
                $("#prize-result").html(data.message);
            },
            'json');
    });
    
    /*send parcel*/
    $("#sendParcel").click(function(){
        $("#prize-result").empty();
        
        $.post(ajaxURL, 
            {task: "sendParcel"}, 
            function(data){
                if(data.state == "success"){
                    $("#money-block, #material-block").addClass("d-none");
                    $("#declineprize").addClass("d-none");$("#getprize").removeClass("d-none");
                    cleanFields();
                }
                $("#prize-result").html(data.message);
            },
            'json');
    });
    $("#bonusAmount").text($("#loyaltyBonus").val());
});

function setFields(fields){
    $.each(fields, function(i,e){
        $("#prize-params #prize-"+i).val(e);
    });
}
//очистить поля с данными по призу
function cleanFields(){
    $.each($("#prize-params input"), function(i,e){
        $(this).val("");
    });
}