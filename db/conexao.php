<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $serverEnvDirectory = '/home/xpt123';
    $serverEnvFilename = 'lumassali.env';
    if (is_file($serverEnvDirectory . DIRECTORY_SEPARATOR . $serverEnvFilename)) {
        $dotenv = Dotenv\Dotenv::createImmutable($serverEnvDirectory, $serverEnvFilename);
    } else {
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__), '.env');
    }

    if (!isset($_ENV['DATABASE_HOST'])) {
        $dotenv->load();
    }
    $dotenv->required([
        'DATABASE_HOST',
        'DATABASE_USER',
        'DATABASE_PASS',
        'DATABASE_NAME',
    ])->notEmpty();

    $DATABASE_HOST = $_ENV['DATABASE_HOST'];
    $DATABASE_USER = $_ENV['DATABASE_USER'];
    $DATABASE_PASS = $_ENV['DATABASE_PASS'];
    $DATABASE_NAME = $_ENV['DATABASE_NAME'];

    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $con->set_charset("utf8");
    // if ( mysqli_connect_errno() ) {
    //     // If there is an error with the connection, stop the script and display the error.
    //     $error_message = 'Failed to connect to MySQL: ' . mysqli_connect_error();
    //     echo "<script>console.error(" . json_encode($error_message) . ");</script>";
    //     exit;
    // }
    // echo "<script>console.error(" . json_encode("aaaaaaa") . ");</script>";
    // exit;
    function novaVersao() {
        $file = 'versao.json';
        $data = json_decode(file_get_contents($file), true);

        $data['versao']++;

        file_put_contents($file, json_encode($data));
    }
?>  