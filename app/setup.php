<?php
require '../vendor/autoload.php';

function setup_database()
{
    echo "setting up database...\n";
    $host = getenv('DB_PORT_5984_TCP_ADDR');
    $port = getenv('DB_PORT_6379_TCP_PORT');
    $dbname = 'affili8';
    $url = $host . ':' . $port . '/' . $dbname;
    $request = new BCA\CURL\CURL($url);
    $request->put();
    echo "done\n";
}
setup_database();
