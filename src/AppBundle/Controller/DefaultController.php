<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vehicle;
use AppBundle\Type\VehicleSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $searchForm = $this->createForm(VehicleSearchType::class, null, [
            'action' => $this->generateUrl('detailed_search'),
        ]);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->getResultsAction($searchForm, $request);
        }
        return $this->render(
            'AppBundle:default:index.html.twig',
            ['searchForm' => $searchForm->createView()]
        );
    }

    /**
     * @Route("/search/{page}", name="detailed_search", requirements={"page": "^[1-9]\d*$"})
     */
    public function searchAction(Request $request, $page = 1)
    {
        $searchForm = $this->createForm(VehicleSearchType::class, null);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->getResultsAction($searchForm, $request, $page);
        }
        return $this->render('AppBundle:default:detailed_search.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }

    public function getResultsAction(Form $searchForm, Request $request, $page = 1)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:Vehicle');
        $queryVehicleParams = $request->query->all();
        $results = $repository->findAllByCriteria($queryVehicleParams, $page);
        return $this->render('AppBundle:default:results_page.html.twig', [
            'items' => $results['vehicles'],
            'total_pages_count' => $results['total_pages_count'],
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route(
     *     "/vehicle/{pin_action}/{id}",
     *     name="pin_vehicle",
     *     options = {"expose" = true},
     *     requirements={"id": "\d+", "pin_action": "pin|unpin"}
     * )
     */
    public function pinVehicleAction($id, $pin_action)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new JsonResponse('error');
        }
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:Vehicle');
        $vehicle = $repository->find($id);
        if ($vehicle !== null) {
            $user = $this->getUser();
            if ($pin_action === 'pin') {
                $user->addPinnedVehicle($vehicle);
            } elseif ($pin_action === 'unpin') {
                $user->removePinnedVehicle($vehicle);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $translator = $this->get('translator.default');
            if ($pin_action === 'pin') {
                return new JsonResponse($translator->trans('results.pin.pinned'));
            } elseif ($pin_action === 'unpin') {
                return new JsonResponse($translator->trans('results.pin.unpinned'));
            }
        }
        return new JsonResponse('error');
    }

    /**
     * @Route("/generate", name="generate_fakes")
     */
    public function generateFakesAction()
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $brands = $entityManager->getRepository('AppBundle:Brand')->findAll();
        $models = $entityManager->getRepository('AppBundle:Model')->findAll();
        $bodyTypes = $entityManager->getRepository('AppBundle:BodyType')->findAll();
        $fuelTypes = $entityManager->getRepository('AppBundle:FuelType')->findAll();
        $countries = $entityManager->getRepository('AppBundle:Country')->findAll();
        $cities = $entityManager->getRepository('AppBundle:City')->findAll();
        $colors = $entityManager->getRepository('AppBundle:Color')->findAll();
        for($i = 0; $i < 100; $i++)
        {
            $vehicle = new Vehicle();
            $vehicle->setBrand($brands[$i%sizeof($brands)]);
            $vehicle->setBodyType($bodyTypes[$i%sizeof($bodyTypes)]);
            $vehicle->setModel($models[$i%sizeof($models)]);
            $vehicle->setFuelType($fuelTypes[$i%sizeof($fuelTypes)]);
            $vehicle->setCountry($countries[$i%sizeof($countries)]);
            $vehicle->setCity($cities[$i%sizeof($cities)]);
            $vehicle->setColor($colors[$i%sizeof($colors)]);
            $vehicle->setClimateControl("Lala");
            $vehicle->setDefects("Lala");
            $vehicle->setDoorsNumber($i % 4);
            $vehicle->setSeatsNumber($i % 4);
            $vehicle->setDriveType("Gaga");
            $vehicle->setEngineSize($i*1000 % 2000);
            $vehicle->setMileage($i*100000 % 100000);
            $vehicle->setProviderId($i * 100000 % 200000);
            $vehicle->setProvider("Autoplius");
            $vehicle->setLink("https://www.Autoplius.lt");
            $vehicle->setPrice($i * 4211 % 10000);
            $vehicle->setYear($i * 515151 % 2010);
            $vehicle->setPower($i * 545 % 100);
            $vehicle->setTransmission("RW");
            $vehicle->setSteeringWheel($i % 2);
            $vehicle->setWheelsDiameter($i % 20);
            $vehicle->setWeight($i * 5454 % 2000);
            $entityManager->persist($vehicle);

        }
        $entityManager->flush();
        return $this->render('AppBundle:default:index.html.twig');
    }
}
