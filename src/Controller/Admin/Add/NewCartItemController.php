<?php

namespace App\Controller\Admin\Add;

use App\Entity\ActualCartItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use App\Form\ActualCartItemType;
use App\Repository\ActualCartItemRepository;
use Symfony\Component\HttpFoundation\Request;

class NewCartItemController extends AbstractController
{
    /**
     * @Route("/admin/new/cart/item", name="admin_new_cart_item")
     */
    public function index(Request $request, ManagerRegistry $doctrine, ActualCartItemRepository $actualCartItemRepository): Response
    {

        $form = $this->createForm(ActualCartItemType::class);
        $form->handleRequest($request);
        $actualCart = $actualCartItemRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $newCartItem = new ActualCartItem();
            $newCartItem = $form->getData();
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($newCartItem);
            $entityManager->flush();

            return $this->redirectToRoute('admin_new_cart_item');
        }

        return $this->render('admin/new/new_cart_item/index.html.twig', [
            'actualCart' => $actualCart,
            'cart_form' => $form->createView(),
        ]);
    }
}
