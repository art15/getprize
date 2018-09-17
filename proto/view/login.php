<?php
/**
 * Date: 2018/09/15 
 * Author: ASeryakov
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
                <div class="form-group mb-lg field-loginform-username required">
                    <label class="control-label " for="loginform-username">Логин</label>

                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </span>
                        <input type="text" id="loginform-username" class="form-control">
                    </div>
                </div>
                <div class="form-group mb-lg field-loginform-password required">
                    <label class="control-label " for="loginform-password">Пароль</label>
                    <div class="input-group input-group-icon">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </span>
                        <input type="password" id="loginform-password" class="form-control"/>
                    </div>
                </div>
                <div id="login-message-block"></div>
                <div class="text-right">
                    <button type="button" class="btn btn-info" id="loginform-button" >Войти</button>
                </div>
            </div>
        </div>
    </div>
</div>
