<?php
/**
 * Date: 2018/09/15 
 * Author: ASeryakov
 */
/*
if(){ //если пришел AJAX-запрос..
    $password = ''
    if($_POST['username'] == 'test' && ){
        
        
    }
    exit;
}
*/
?>
<div class="container">
    <h1>Вход</h1>
    <div class="mx-auto" style="width:300px;">
        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right">
                <p>Пожалуйста, заполните поля для входа:</p>
            </div>
            <div class="panel-body">
                <form id="login-form" class="form-horizontal" action="" method="post" role="form">
                    <div class="form-group mb-lg field-loginform-username required">
                        <label class="control-label " for="loginform-username">Логин</label>

                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </span>
                            <input type="text" id="loginform-username" class="form-control input-lg">
                        </div>
                        <div class="help-block help-block-error "></div>
                    </div>
                    <div class="form-group mb-lg field-loginform-password required">
                        <label class="control-label " for="loginform-password">Пароль</label>
                        <div class="input-group input-group-icon">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </span>
                            <input type="password" id="loginform-password" class="form-control input-lg" name="LoginForm[password]" />
                        </div>
                        <div class="help-block help-block-error "></div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-info" id="login-button" >Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
