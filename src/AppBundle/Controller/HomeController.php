<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Institution;
use  Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@App/home/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'institutions' => $this->getInstitutionsAction(),
        ]);
    }

    public function getInstitutionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $institutions = $em->getRepository(Institution::class)->findAll();

        return $this->render('@App/institutions.html.twig', [
            'institutions' => $institutions
        ]);
    }
}
