<?php


namespace App\Controller\service;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    private HttpClientInterface $data;
    public function __construct(HttpClientInterface $data)
    {
        $this->data = $data;
    }

    public function getDataShip() : array
    {
        $response = $this->data->request(
            'GET',
            'http://api.starcitizen-api.com/DZQ88D1xNFb573V5G2vxYWiNns4XBROS/v1/cache/ships'
        );
        return $response->toArray();
    }

//    public function getDataPlay() : array
//    {
//        $response = $this->data->request(
//            'GET',
//            'http://api.starcitizen-api.com/DZQ88D1xNFb573V5G2vxYWiNns4XBROS/v1/gamedata/list/categories'
//        );
//        return $response->toArray();
//
//    }
}
