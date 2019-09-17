<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Institution;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route(path="/donation", methods={"GET"})
 */
class InstitutionController extends Controller
{
    public function getAllInstitutionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $institutions = $em->getRepository(Institution::class)->findAll();

        return $this->render('@App/institutions_donation_form.html.twig', [
            'institutions' => $institutions,
        ]);
    }
}