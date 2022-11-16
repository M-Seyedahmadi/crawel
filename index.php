<?php
//foreach ($crawler as $domElement) {
//var_dump($domElement->nodeName);
//}

require_once "vendor/autoload.php";
require_once "database/database.php";
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
crawlerAction();
//ImageAction();

function crawlerAction()
{
    echo CountByStatusCode(200);
    $url = "https://www.eghamat24.com/";

    $all_links = getLinks($url)['links'];
    $all_images = getLinks($url)['images'];
    foreach ($all_links as $link) {
        $all_links = array_merge($all_links, getLinks($link)['links']);
        $all_images = array_merge($all_images, getLinks($link)['images']);
    }

    if (!empty($all_links)) {
        echo "All Avialble Links From this page $url Page<pre>"; print_r($all_links);echo "</pre>";
    } else {
        echo "No Links Found";
    }
    die;
}


function getLinks($url)
{
    $client = new Client();

    try {
        $response = $client->request('GET', $url);
    }    catch (Exception $e) {
        $response = $e->getResponse();
        $message = $e->getMessage();
        echo $message;
        $responseBodyAsString = $response->getBody()->getContents();
    }

    $crawler = new Crawler((string)$response->getBody());
    $images = ImageAction($crawler);
    $links_count = $crawler->filter('a[href]')->count();
    if($links_count > 0) {
        $links = $crawler->filter('a')->each(function ($node) use ($url) {
            $link = $node->attr('href');
            if (str_contains($link, $url)) {
                return $link;
            }
        });

        $linksDetails = [];
        foreach (array_unique($links) as $link) {
            $linksDetails[] = get_link_detail($link);
        }
        return [
            'links' => $linksDetails,
            'images' => $images,
            ];
    }
    return [];
}
function get_link_detail($link){
    $client = new Client();
    $response = $client->request('GET', $link);
    $crawler = new Crawler((string)$response->getBody());
    $text = $crawler->filter('a[href]')->text();
    if() {

    } else {

    }

    return [
        'link'=>$link,
        'response_code'=> $response ->getStatusCode(),
        'text' => $text,
    ];
}
function ImageAction($crawler){
    return $crawler->filter('img')->each(function ($node) {
        return $node->image();
    });
}
