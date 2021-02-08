<?php

namespace ICS\CelebrityBundle\Service;

use DateTime;
use ICS\CelebrityBundle\Entity\Celebrity;
use ICS\SearchBundle\Service\QwantService;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CelebrityService
{

    private $client;
    private $qwant;

    public function __construct(QwantService $qwant, HttpClientInterface $client)
    {
        $this->qwant = $qwant;
        $this->client = $client;
    }

    function search($search)
    {
        $result = [];

        $searchAddon = [];
        $searchAddon[] = "";
        $searchAddon[] = "legs";
        $searchAddon[] = 'dress';
        $searchAddon[] = 'swimsweat';
        $searchAddon[] = 'photoshoot';
        $searchAddon[] = 'miniskirt';
        $searchAddon[] = 'leather';
        $searchAddon[] = 'pants';
        $searchAddon[] = (new DateTime())->format('Y');

        foreach ($searchAddon as $addon) {
            $result[$addon] = $this->search_multi($search, $addon);
        }

        return $result;
    }

    function search_multi($search, $addon)
    {
        $result = $this->qwant->search($search . " " . $addon, 50, 0, 'images')->data->result->items;

        return $result;
    }

    function getInfos(Celebrity $celebrity)
    {
        $search = $celebrity->getFullname();
        return $this->getInfosFromCN($search);
    }

    function getInfosFromCN(string $search)
    {
        $celebrityNinjaApiKey = 'yipOYLHqNY9zC3guGs59bw==wjh3w1Gzl2MBctms';
        $celebrityNinjaApiEndPoint = 'https://api.celebrityninjas.com/v1/search?limit=10&name=';

        $headers = [
            'headers' => [
                'X-Api-Key' => $celebrityNinjaApiKey
            ]
        ];
        $response = $this->client->request('GET', $celebrityNinjaApiEndPoint . $search, $headers);

        if ($response->getStatusCode() == 200) {
            $objects = json_decode($response->getContent());
            return $objects;
        }


        return null;
    }
}
