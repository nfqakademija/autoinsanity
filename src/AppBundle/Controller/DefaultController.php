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
        // display database entries
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:Vehicle');
        $items = $repository->findAll();
        return $this->render('AppBundle:default:list_items.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @Route("/crawler", name="crawler")
     */
    public function crawlerAction(Request $request)
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
                $car = ['title' => $title,
                    'price' => $price,
                    'date' => $date];
                $cars[] = $car;
            }

            $pageNumber++;
            sleep(2);

            if ($pageNumber > 3) {
                break;
            }

        }
        $response = new JsonResponse($cars);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
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
