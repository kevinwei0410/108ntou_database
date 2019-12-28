<?php
include_once 'Request.php';
include_once 'Router.php';
require_once 'vendor/autoload.php';

$router = new Router(new Request);
$user = 'root';
$passwd = 'sealion';
$dsn = 'mysql:host=localhost;dbname=DBGroup14';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
);

try {
    $db_conn = new PDO($dsn, $user, $passwd, $options);
} catch (PDOException $e) {
    die("Database connection failed!\n" . $e->getMessage());
}

$router->get('/index.php', function () {
    return <<<HTML
    <head>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <style> body{ font-family: 'Noto Sans TC', sans-serif; } </style>
    </head>
    <h1>第十四組資料庫專案</h1>
    <h2>Students</h2>
    <ul>
        <li><a href="student/schedule">Schedules</a></li>
        <li><a href="student/courses">Courses</a></li>
    </ul>
    <h2>Admin</h2>
    <ul>
        <li><a href="admin/courses">Courses</a></li>
    </ul>
    HTML;
});

$router->get('/home', function ($request) {
});

$router->get('/student/schedule', function ($request) use ($db_conn) {
    $sql = "select * from student_schedule;";
    $statement = $db_conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    echo $request->twig->render('@student/schedule.html', [
        'result' => $result,
    ]);
});

$router->get('/student/courses', function ($request) use ($db_conn) {
    $sql = "select * from semester_course;";
    $statement = $db_conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    echo $request->twig->render('@student/courses.html', [
        'result' => $result,
    ]);
});

$router->get('/admin/courses', function ($request) use ($db_conn) {
    $sql = "select * from semester_course;";
    $statement = $db_conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    echo $request->twig->render('@admin/courses.html', [
        'result' => $result,
    ]);
});

$router->post('/admin/courses', function ($request) use ($db_conn) {

    if (isset($_POST['confirmDel'])) {
        $sql = <<<SQL
DELETE FROM semester_course WHERE
lecture_section=:section AND
course_name=:name AND
instructor_name=:instructor;
SQL;
        $statement = $db_conn->prepare($sql);
        $statement->execute(array(
            ':section' => $_POST['course']['section'],
            ':name' => $_POST['course']['name'],
            ':instructor' => $_POST['course']['instructor'],
        ));
    } else if (isset($_POST['confirmAdd'])) {
        $sql = <<<SQL
INSERT INTO semester_course VALUES
(:section, :name, :instructor, :credits, :max_students, :enrolled, :semester);
SQL;
        $statement = $db_conn->prepare($sql);
        $statement->execute(array(
            ':section' => $_POST['course']['section'],
            ':name' => $_POST['course']['name'],
            ':instructor' => $_POST['course']['instructor'],
            ':credits' => $_POST['course']['credits'],
            ':max_students' => $_POST['course']['max_students'],
            ':enrolled' => 0,
            ':semester' => $_POST['course']['semester'],
        ));
    }
    $sql = 'SELECT * FROM semester_course;';
    $statement = $db_conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    echo $request->twig->render('@admin/courses.html', [
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
