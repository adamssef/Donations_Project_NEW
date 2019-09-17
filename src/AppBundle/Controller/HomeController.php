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
        ]);
    }

    public function getInstitutionsAction()//GET ALL INSTITUTUTIONS - TO BE PLACED IN REPOSITORY
    {
        $em = $this->getDoctrine()->getManager();
        $institutions = $em->getRepository(Institution::class)->getInstitutionsOrderedByDonations();
//        $result = $institutions->createQueryBuilder('i')
//            ->select('i, d')
//            ->join('i.donations', 'd')
//            ->orderBy('d.quantity')
//            ->getQuery()
//            ->getResult();



        return $this->render('@App/institutions.html.twig', [
            'institutions' => $institutions,
        ]);
    }

    public function getTotalNumberOfDonationBagsAction() //TO BE PLACED IN REPOSITORY
    {
        $em = $this->getDoctrine()->getManager();
        $donations = $em->getRepository(Donation::class)->getTotalNumberOfDonationBags();
//        $result = $donations->createQueryBuilder('d')
//            ->select('SUM(d.quantity) as totalBags')
//            ->getQuery()
//            ->getResult();



        return $this->render('@App/totalBags.html.twig', [
            'bagsTotal' => $donations,
        ]);
    }


    public function getTotalNumberOfInstitutionsAction() //TO BE PLACED IN REPOSITORY
    {
        $em = $this->getDoctrine()->getManager();
        $institutions = $em->getRepository(Institution::class)->getTotalNumberOfOrgs();
//        $result = $institutions->createQueryBuilder('i')
//            ->SELECT('COUNT(i.id) as numberOfOrgs')
//            ->getQuery()
//            ->getResult();


        return $this->render('@App/totalOrgs.html.twig', [
            'totalOrgs' => $institutions,
        ]);
    }
}
