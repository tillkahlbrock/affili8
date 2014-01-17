<?php
require '../vendor/autoload.php';

$options = array(
    'dbname' => 'affili8',
    'host' => '172.17.0.97', //TODO read from ENV
    'port' => 5984, //TODO read from ENV
);

$client = \Doctrine\CouchDB\CouchDBClient::create($options);

list($id, $rev) = $client->postDocument(array('foo' => 'bar'));
$client->putDocument(array('foo' => 'baz'), $id, $rev);

$doc = $client->findDocument($id);

print_r($doc);