<?php

namespace frontend\services;

use Exception;
use GuzzleHttp\Client;
use yii\helpers\Json;

class LocationService
{
    protected $data;
    protected $token = 'e666f398-c983-4bde-8f14-e3fec900592a';
    protected $format = 'json';
    protected $base_uri = 'https://geocode-maps.yandex.ru/';
    protected $uri = '1.x';
    protected $client;


    /**
     * LocationService constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->base_uri
        ]);
    }

    /**
     * @param string $address
     * @return string
     */

    protected function sendResponse(string $address): array
    {
        $response = $this->client->request('GET', $this->uri, [
            'query' => [
                'apikey' => $this->token,
                'geocode' => $address,
                'format' => $this->format
            ]
        ]);

        return Json::decode($response->getBody()->getContents(), true);
    }

    /**
     * @param $address
     * @return string
     * @throws Exception
     */

    public function getResponse(string $address): string
    {
        $data = $this->sendResponse($address);
        $result = [];

        if (!isset($data)) {
            throw new Exception('Результата не найдено');
        }

        foreach ($data['response']['GeoObjectCollection']['featureMember'] as $item) {
            array_push($result, $item['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']);
        }

        return Json::encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * @param $address
     * @return string
     * @throws Exception
     */

    public function getCoords(string $address): string
    {
        $data = $this->sendResponse($address);

        if (!isset($data)) {
            throw new Exception('Результата не найдено');
        }

        return Json::encode($data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
