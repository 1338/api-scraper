<?php
namespace Rootshell\ApiScraper;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Scraper
 * @package Rootshell\ApiScraper
 */
class Scraper
{
    private $scraper;
    private $baseSlug;

    /**
     * Scraper constructor.
     * @param $startURL
     * @param bool $access
     * @param bool $secret
     */
    public function __construct($startURL, $access = false, $secret = false) {
        $baseSlug = parse_url($startURL, PHP_URL_PATH);

        if(!empty($baseSlug)) {
            if(!substr($baseSlug, -1, 1) == '/') {
                $baseSlug .= '/';
            }
        }

        $this->baseSlug = $baseSlug;

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

    /**
     * @param string $type
     * @param $endpoint
     * @param $options
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function request($type = 'GET', $endpoint, $options = []) {
        try {
            return $this->scraper->request(
                $type,
                "{$this->baseSlug}$endpoint",
                $options
            );
        } catch (GuzzleException $e) {
            return false;
        }
    }
}