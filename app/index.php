<?php
require '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app->post('/affiliates', function(Request $request) use($app) {
        $data = $request->getContent();
        $repository = new AffiliateRepository(new DatabaseClient());
        $ids = $repository->create($data);
        return new Response(json_encode($ids), 201);
    });

$app->run();

class AffiliateRepository
{
    /**
     * @var DatabaseClient
     */
    private $databaseClient;

    public function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public function create($data)
    {
        return $this->databaseClient->store($data);
    }
}

class DatabaseClient
{
    public function store($data)
    {
        $host = getenv('DB_PORT_5984_TCP_ADDR');
        $port = getenv('DB_PORT_5984_TCP_PORT');
        $dbName = 'affiliates';

        $url = $host . ':' . $port . '/' . $dbName;

        $curl = new BCA\CURL\CURL($url);
        $curl->header('Content-Type', 'application/json');
        $responseArray = json_decode($curl->post($data)->__toString(),true);
        return array('id' => $responseArray['id'], 'rev' => $responseArray['id']);
    }
}
