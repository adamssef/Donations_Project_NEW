<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Institution;
use AppBundle\Entity\Donation;
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

    public function getTotalNumberOfDonationBagsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $donations = $em->getRepository(Donation::class)->findAll();
        $bagsTotal= 0;
        foreach ($donations as $donation) {
            $bagsTotal += $donation->getQuantity();
        }

        return $this->render('@App/totalBags.html.twig', [
            'bagsTotal' => $bagsTotal,
        ]);
    }


    public function getTotalNumberOfInstitutionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $institutions = $em->getRepository(Institution::class)->findAll();
        $institutionTotal= 0;
        foreach ($institutions as $institution) {
            $institutionTotal ++;
        }

        return $this->render('@App/totalOrgs.html.twig', [
            'totalOrgs' => $institutionTotal,
        ]);
    }
}
