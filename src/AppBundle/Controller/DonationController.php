<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Donation;
use Symfony\Component\HttpFoundation\Request;


/**
 *
 * @Route(path="/donation", methods={"GET"})
 */
class DonationController extends Controller
{

    /**
     * Creates a new donation entity.
     *
     * @Route(path="/new", name="donation_new", methods={"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $donation = new Donation();
        $form = $this->createForm('AppBundle\Form\DonationType', $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('donation_confirmation', array('id' => $donation->getId()));
        }
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_USER', null, 'Access allowed only to registered Users!']);
        return $this->render('@App/donate/form.html.twig', array(
            'form' => $form->createView(),
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
    /**
     * @Route(path="/donation/success", name="donation_confirmation", methods={"GET", "POST"})
     */
    public function formConfirmationAction()
    {
        return $this->render('@App/donate/form_confirmation.html.twig');
    }
}
