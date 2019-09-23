<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Donation;
use Symfony\Component\HttpFoundation\Request;
use Twig\Loader\LoaderInterface;
use Twig_Environment;


class DonationController extends Controller
{

    public function newAction(Request $request)
    {
        $donation = new Donation();
        $form = $this->createForm('AppBundle\Form\DonationType', $donation);
        $form->handleRequest($request);

        $session = new Session();
        $session->set('logname', ucfirst($_SERVER['LOGNAME']));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('donation_confirmation', [
                'id' => $donation->getId()
            ]);
        }



        return $this->render('@App/donate/form.html.twig', array(
            'form' => $form->createView(),
            'logname' => ucfirst($_SERVER['LOGNAME']),
        ));
    }

    public function getAllCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render('@App/categories.html.twig', [
            'categories' => $categories,
        ]);
    }



    public function formConfirmationAction()
    {
        return $this->render('@App/donate/form_confirmation.html.twig');
    }

}
