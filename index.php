<?php
include_once 'Request.php';
include_once 'Router.php';
require_once 'vendor/autoload.php';

$router = new Router(new Request);

$router->get('/', function () {
    return <<<HTML
    <h1>第十四組資料庫專案</h1>
    HTML;
});

$router->get('/home', function ($request) {
});

$router->get('/student_schedule', function ($request) {
    $user = 'root';
    $passwd = 'sealion';
    $dsn = 'mysql:host=localhost;dbname=DBGroup14';
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    try {
        $conn = new PDO($dsn, $user, $passwd, $options);
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
    $stmt = $conn->prepare("select * from student_schedule;");
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo $request->twig->render('@student/schedule.html', [
        'result' => $result,
    ]);
});

$router->get('/server_info', function ($request) {
    $indicesServer = array('PHP_SELF',
        'argv',
        'argc',
        'GATEWAY_INTERFACE',
        'SERVER_ADDR',
        'SERVER_NAME',
        'SERVER_SOFTWARE',
        'SERVER_PROTOCOL',
        'REQUEST_METHOD',
        'REQUEST_TIME',
        'REQUEST_TIME_FLOAT',
        'QUERY_STRING',
        'DOCUMENT_ROOT',
        'HTTP_ACCEPT',
        'HTTP_ACCEPT_CHARSET',
        'HTTP_ACCEPT_ENCODING',
        'HTTP_ACCEPT_LANGUAGE',
        'HTTP_CONNECTION',
        'HTTP_HOST',
        'HTTP_REFERER',
        'HTTP_USER_AGENT',
        'HTTPS',
        'REMOTE_ADDR',
        'REMOTE_HOST',
        'REMOTE_PORT',
        'REMOTE_USER',
        'REDIRECT_REMOTE_USER',
        'SCRIPT_FILENAME',
        'SERVER_ADMIN',
        'SERVER_PORT',
        'SERVER_SIGNATURE',
        'PATH_TRANSLATED',
        'SCRIPT_NAME',
        'REQUEST_URI',
        'PHP_AUTH_DIGEST',
        'PHP_AUTH_USER',
        'PHP_AUTH_PW',
        'AUTH_TYPE',
        'PATH_INFO',
        'ORIG_PATH_INFO');

    echo $request->twig->render('@about/server.html', [
        'server' => $_SERVER,
        'indicesServer' => $indicesServer,
    ]);
});
