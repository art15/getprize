<?php
/**
 * Date: 2018/09/15 
 * Author: ASeryakov
 * AJAX with json output
 */
use cls\Calculate;

$params = require(__DIR__ . '/params/cfg.php');

//If was an AJAX request..
if(!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") { 
    /*set default variables*/
    $content = $_POST;
    $task = $content["task"];
    $state = "unknown";
    $message = "";
    $data = [];
    $test_login = "test";
    $test_pwd = "qwerty";
    
    if(empty($task)){
        $state = "error";
        $message = "Не определено задание для выполнения";
    }else{
        switch($task){
            case "login": //авторизация
                //TODO: сделать авторизацию более защищенной
                //TODO: использовать шифрование паролей
                if(     !empty($content["login"]) 
                        && ($content["login"] == $test_login) 
                        && !empty($content["pwd"]) 
                        && ($content["pwd"] == $test_pwd ) ){
                    $_SESSION["auth_user"] = [
                        "id" => "1",
                        "name" => $test_login,
                        "loyaltyBonus" => 0
                    ];
                    $state = "success";
                }else{
                    $state = "error";
                    $message = "Неправильный логин или пароль";
                }
                break;
            case "logout": //выход пользователя из системы
                    unset($_SESSION["auth_user"]);
                    $state = "success";
                break;
            case "getPrize": //получить приз
                    //получаем ответ
                    $response = (new Calculate())->getPrize();
                    exit(json_encode($response));
                    //$state = $response[state];
                break;
            case "declinePrize"; //отказ от приза
                    $response = (new Calculate())->declinePrize();
                    exit(json_encode($response));
                break;
            case "moneyToBankAccount": //перевод денег на счет в банке
                    $response = (new Calculate())->moneyToBankAccount();
                    exit(json_encode($response));
                break;
            case "moneyConvertToBonus": //конвертация денег в бонусы
                    $response = (new Calculate())->moneyConvertToBonus();
                    exit(json_encode($response));
                break;
            case "sendParcel": //запрос на отправку посылки почтой
                    //здесь можно описать процесс уведомления работника, что, куда, как и кому отправлять.
                    //после отправки работник должен уведомить пользователя
                    $response = (new Calculate())->sendParcel();
                    exit(json_encode($response));
                break;
        }
    }
    //общий выход с определенными переменными
    exit(json_encode(['state' => $state, 'message' => $message, 'data'=> $data]));
}
exit("разрешен только AJAX запрос");