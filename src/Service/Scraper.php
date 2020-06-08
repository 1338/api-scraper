<?php
namespace Rootshell\ApiScraper;

use GuzzleHttp\Client as HttpClient;


class Scraper
{
    private $scraper;

    public function __construct($startURL, $access = false, $secret = false) {
        $httpOptions = [
            'base_uri'  =>  $startURL,
            'auth'      =>  [],
            "http_errors" => true
        ];
        if($access) {
            $httpOptions['auth'][] = $access;
        }
        if($secret) {
            $httpOptions['auth'][] = $secret;
        }
        $this->scraper = new HttpClient($httpOptions);
    }

    public function get($endpoint) {
        return $this->scraper->get($endpoint);
    }

    public function post($endpoint, $options){
        return $this->scraper->post($endpoint, $options);
    }
}