<?php


namespace App\Controller\service;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    private $ship;
    public function __construct(HttpClientInterface $ship)
    {
        $this->ship = $ship;
    }

    public function getDataShip() : array
    {
        $response = $this->ship->request(
            'GET',
            'http://api.starcitizen-api.com/DZQ88D1xNFb573V5G2vxYWiNns4XBROS/v1/cache/ships'
        );
        return $response->toArray();
    }
}
