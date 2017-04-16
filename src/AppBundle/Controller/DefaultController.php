<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // display database entries
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:Vehicle');
        $items = $repository->findAll();

        return $this->render('AppBundle:default:list_items.html.twig', [
            'items' => $items,
        ]);
    }
}
