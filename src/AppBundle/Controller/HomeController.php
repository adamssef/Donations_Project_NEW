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

        $reponse = (json_last_error($this->getInstitutionsAction()));
        var_dump($reponse);

        return $this->render('@App/home/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'institutions' => $this->getInstitutionsAction(),
        ]);
    }

    public function getInstitutionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $institutions = $em->getRepository(Institution::class)->findAll();
        foreach ($institutions as $institution) {
            $institution = "<li>
                                <div class='col'>
                                    <div class='title'>".$institution->getName()."</div>
                                    <div class='subtitle'>".$institution->getDescription()."</div>
                                </div>
                            </li>";
            return new JsonResponse($htmls);

        }
    }
}
