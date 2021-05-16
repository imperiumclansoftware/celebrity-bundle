<?php

namespace ICS\CelebrityBundle\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;;

class WikipediaService
{
    private $httpClient;
    private $qwantClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function Search(string $search)
    {
        $results = [];
        $url="https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch=".trim($search)."&format=json";
        $response = $this->httpClient->request('GET', $url);

        if (200 == $response->getStatusCode()) {

            $results=json_decode($response->getContent());
            $results=$results->query->search;

            return $results;
        }

        return null;
    }

    public function getPage($title)
    {
        $url="https://fr.wikipedia.org/w/api.php?action=parse&page=".$title."&prop=text&formatversion=2&format=json";
        $response = $this->httpClient->request('GET', $url);

        if (200 == $response->getStatusCode()) {
            $result=json_decode($response->getContent());
            return $result->parse;
        }

        return null;
    }

    public function getIntro($title)
    {
        $url="https://fr.wikipedia.org/w/api.php?action=query&titles=".$title."&prop=extracts&exintro&formatversion=2&format=json";
        $response = $this->httpClient->request('GET', $url);

        if (200 == $response->getStatusCode()) {
            $result=json_decode($response->getContent());
            return $result->query->pages[0];
        }

        return null;
    }
}