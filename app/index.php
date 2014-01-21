<?php
require '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app->post('/affiliates', function(Request $request) use($app) {
        $data = $request->getContent();
        return $data;
        $repository = new AffiliateRepository(new DatabaseClient());
        $id = $repository->create($data);
        return new Response(json_encode(array('id' => $id)), 201);
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
        $id = $this->databaseClient->store($data);
        return $id;
    }
}

class DatabaseClient
{
    public function store($data)
    {
        $host = getenv('DB_PORT_5984_TCP_ADDR');
        $port = getenv('DB_PORT_6379_TCP_PORT');
        $dbname = 'affili8';
        $url = $host . ':' . $port . '/' . $dbname;
        $request = new BCA\CURL\CURL($url);
        return $request->put($data);
    }
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