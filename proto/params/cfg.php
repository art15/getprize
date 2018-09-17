<?php
/**
 * Date: 2018/09/15 
 * Author: ASeryakov
 * настройки
 */
//автозагрузчик 
function __autoload($c)
{
    require_once $c.".php";
}
if ( ! session_id() ) @ session_start();

?>