<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //set_time_limit(60);
        $hasItems = true;
        $cars = [];
        $pageNumber = 1;
        while ( $hasItems ) {
            $url = "https://autoplius.lt/skelbimai/naudoti-automobiliai?make_id=99&page_nr=" . $pageNumber;
            $html = $this->getHtml($url);
//            $html = file_get_contents('test.txt');

            $hasItems = false;
            $crawler = new Crawler($html);
            $crawler = $crawler->filter('.item-section');

            foreach ($crawler as $domRow) {
                $hasItems = true;
                $row = new Crawler($domRow);
                $title = $row->filter('.title-list a')->text();
                $price = trim($row->filter('.price-list')->text());
                $date = $row->filter('.param-list span[title="Pagaminimo data"]')->text();
                $car = [$title, $price, $date];
                $cars[] = $car;
            }

            $pageNumber++;
            sleep(2);

            if ($pageNumber > 3) {
                break;
            }

        }
        return new JsonResponse($cars);
    }

    public function getHtml($url)	{
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }

}
