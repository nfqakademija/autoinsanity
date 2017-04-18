<?php

namespace AppBundle\Service;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;

class WebCrawler
{
    protected $em;
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Constructor
     *
     * @param EventDispatcherInterface $dispatcher
     * @param EntityManager $em
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em)
    {
        $this->dispatcher = $dispatcher;
        $this->em = $em;
    }

    public function startCrawler($id, $startPage, $endPage)
    {
        $hasItems = true;
        $cars = [];
        $details = [];

        $pageNumber = 1;
        while ( $hasItems ) {
            $url = "https://autoplius.lt/skelbimai/naudoti-automobiliai?make_id=" . $id ."&page_nr=" . $startPage;
            $html = $this->getHtml($url);

            $hasItems = false;
            $crawler = new Crawler($html);
            $crawler = $crawler->filter('.item-section');

            foreach ($crawler as $domRow) {
                $hasItems = true;
                $row = new Crawler($domRow);

                $innerUrl = $row->filter('.title-list a')->attr('href');
                $innerHtml = $this->getHtml($innerUrl);
                $innerCrawler = new Crawler($innerHtml);

                $title = $innerCrawler->filter('.classifieds-info h1')->text();
                $tempArr = explode(",", $title);

                $price = trim($innerCrawler->filter('.classifieds-info .view-price')->text());

                $items = $innerCrawler->filterXPath('//table[@class="announcement-parameters"][1]//tr');
                foreach ($items as $domInnerRow) {
                    $row = new Crawler($domInnerRow);
                    $key = $row->filterXPath("//th")->text();
                    $value = $row->filterXPath("//td")->text();

                    $details[] = [$key, $value];
                }

                $car = [
                    'brand' => $tempArr[0],
                    'engineSize' => trim($tempArr[1]),
                    'price' => $price,
                    'details' => $details,
                    ];
                $cars[] = $car;
            }

            $pageNumber++;

            $this->dispatcher->dispatch(
                'test',
                new GenericEvent($pageNumber)
            );

            sleep(1);

            if ($pageNumber > $endPage) {
                break;
            }

        }

        print_r($cars);

        echo 'Done. All seems OK. ';
        $this->saveToLogger($cars);
        echo 'Saved to web/uploads/file.json ';
//        $this->saveToDb($cars);
//        echo ' Saved to database.';
    }

    public function getHtml($url)	{
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }

    public function saveToLogger($cars) {
        $cars = new JsonResponse($cars);

        $fs = new Filesystem();

        try {
            $fs->dumpFile('web/uploads/file.json', $cars);
        }
        catch(IOException $e) {
        }
    }

    public function saveToDb($cars) {
        foreach ($cars as $car) {

            $brand = new Brand();
            $brand->setName($car['brand']);

            $vehicle = new Vehicle();
            $vehicle->setBrand(1);
            $vehicle->setProviderId(99);
            $vehicle->setProvider('autoplius');
            $vehicle->setLink('autoplius');
            $vehicle->setPrice($car['price']);
            $vehicle->setYear($car['date']);
            $vehicle->setEngineSize(161);
            $vehicle->setPower(161);
            $vehicle->setDoorsNumber(161);
            $vehicle->setSeatsNumber(161);
            $vehicle->setDriveType('autoplius');
            $vehicle->setTransmission('autoplius');
            $vehicle->setClimateControl('autoplius');
            $vehicle->setDefects('autoplius');
            $vehicle->setSteeringWheel(21);
            $vehicle->setWheelsDiameter(21);
            $vehicle->setWeight(21);
            $vehicle->setMileage(21);

            $em = $this->em;
            $em->persist($brand);
            $em->persist($vehicle);
            $em->flush();
        }
    }
}