<?php
//foreach ($crawler as $domElement) {
//var_dump($domElement->nodeName);
//}

require_once "vendor/autoload.php";
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
crawlerAction();
//ImageAction();

function crawlerAction()
{
    $url = "https://www.eghamat24.com/";

    $all_links = getLinks($url)['links'];
    $all_images = getLinks($url)['images'];
    foreach ($all_links as $link) {
        array_push($all_links, getLinks($link)['links']);
        array_push($all_images, getLinks($link)['images']);
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
    $response = $client->request('GET', $url);

    $crawler = new Crawler((string)$response->getBody());
    $images = ImageAction($crawler);
    $links_count = $crawler->filter('a[href]')->count();
    if($links_count > 0) {
        $links = $crawler->filter('a')->each(function ($node) use ($url) {
            $links = $node->attr('href');
            return $links;
        });

        return [
            'links' => array_unique($links),
            'images' => $images,
            ];
    }
    return [];
}

function ImageAction($crawler){
    return $crawler->filter('img')->each(function ($node) {
        return $node->image();
    });
}
