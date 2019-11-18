<?php

namespace App\Manager\Mercure;

use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;

class MercureManager
{
    private $publisher;
    public function __construct
    (
        Publisher $publisher
    )
    {
        $this->publisher = $publisher;
    }
    public function publish( string $topic, string $item, array $data,string $message ,  string $status='success' )
    {
                // update 
        $update = new Update($topic, json_encode(
            [
                'status' => $status,
                'item' => $item,
                'data' => $data,
                'message' => $message
            ]
        ));

        ($this->publisher)($update);
    }
}