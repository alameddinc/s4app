<?php
/**
 * Created by PhpStorm.
 * User: alameddincelik
 * Date: 19.05.2020
 * Time: 22:47
 */

namespace App\Util;


use Symfony\Component\HttpClient\HttpClient;

class ExternalTask
{
    protected $url;
    protected $response;

    protected function __construct($url)
    {
        $this->url = $url;
        $this->response = [];
    }

    protected function fetchTasks()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', $this->url);
        $this->response = $response->toArray();
        return $this;
    }

    protected function filterTasks()
    {
        //
    }

    protected function getResponse()
    {
        return $this->fetchTasks()->filterTasks()->response;
    }

}