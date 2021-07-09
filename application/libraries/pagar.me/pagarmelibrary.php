<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/service/communication.php";

class Pagarme
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var Communication
     */
    private $communication;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->communication = new Communication();
        $this->apiKey = $key;
    }

    /**
     * @param $data
     * @param $type
     * @return false|string
     */
    public function integration($data, $type)
    {
        $data['api_key'] = $this->apiKey;
        return $this->communication->communication($data, $type);
    }
}