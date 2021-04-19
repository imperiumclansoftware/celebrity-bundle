<?php

namespace ICS\CelebrityBundle\Service;

use Exception;
use ICS\CelebrityBundle\Entity\Search\CelebrityResult;
use ICS\QwantBundle\Service\QwantService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CelebrityNinja
{
    private const API_URL = 'https://api.celebrityninjas.com/v1/search?name=';
    private $httpClient;
    private $qwantClient;

    public function __construct(HttpClientInterface $httpClient, QwantService $qwantClient)
    {
        $this->httpClient = $httpClient;
        $this->qwantClient = $qwantClient;
    }

    public function Search(string $search)
    {
        $results = [];
        $headers = [
                'headers' => [
                    'X-Api-Key' => 'yipOYLHqNY9zC3guGs59bw==wjh3w1Gzl2MBctms',
                ],
            ];
        $response = $this->httpClient->request('GET', $this::API_URL.trim($search), $headers);

        if (200 == $response->getStatusCode()) {
            $rawData = json_decode($response->getContent());
            foreach ($rawData as $celebrity) {
                $celeb = new CelebrityResult($celebrity);
                $results[] = $celeb;

                $qres = $this->qwantClient->Search($celeb->getName(), 1, 0, 'images');
                try {
                    $celeb->setImageUrl($qres->data->result->items[0]->media_fullsize);
                } catch (Exception $ex) {
                }
            }
            //TODO: Add Wikipedia Search : https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch=[search]&format=json
            return $results;
        }

        return null;
    }
}
