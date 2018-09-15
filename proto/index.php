<?php
/**
 * Date: 2018/09/15 
 * Author: ASeryakov
 */
?>
 <!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Test proto "Get a prize"</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/fa/css/all.min.css" rel="stylesheet" />
    <link href="/css/custom.css" rel="stylesheet" />
</head>
<body>
    <div id="wait-please" class="wait-please">
        <div class="loader"><i class="fa fa-spinner fa-3x fa-pulse"></i></div>
        <div class="overlay"></div>
    </div>
    <center>
<?php
if(!empty($_SESSION['auth_user'])){ //если прошли авторизацию
    include_once('main.php');
}else{ //вначале надо авторизоваться под пользователем
    include_once('login.php');
}
?>
    </center>
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/main.js"></script>
</body>
</html>