<?php
require '../vendor/autoload.php';

//$options = array(
//    'dbname' => 'affili8',
//    'host' => '172.17.0.97', //TODO read from ENV
//    'port' => 5984, //TODO read from ENV
//);
//
//$client = \Doctrine\CouchDB\CouchDBClient::create($options);
//
//list($id, $rev) = $client->postDocument(array('foo' => 'bar'));
//$client->putDocument(array('foo' => 'baz'), $id, $rev);
//
//$doc = $client->findDocument($id);
//
//print_r($doc);


$app = new Silex\Application();

$app->get('/affiliates/{name}', function($name) {
        return 'Hello ' . $name;
    });

$app->post('/affiliates', function() use($app) {
        $affiliate = create_new_affiliate($app->json());
        $affiliateId = $affiliate->getId();
        return '{"id":"' . $affiliateId . '"}';
    });

$app->run();

/**
 * @param $data
 * @return Affiliate
 */
function create_new_affiliate($data)
{
    return new Affiliate($data);
}

class Affiliate
{
    private $id;

    public function __construct($data = array())
    {
        $this->id = 1;
    }

    public function getId()
    {
        return $this->id;
    }
}