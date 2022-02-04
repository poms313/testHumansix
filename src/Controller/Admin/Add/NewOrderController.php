<?php

namespace App\Controller\Admin\Add;


use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\NewOrderType;
use App\Entity\CartItem;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use \Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\ActualCartItemRepository;
use App\Entity\ActualCartItem;

class NewOrderController extends AbstractController
{
    /**
     * @Route("/admin/new/order", name="admin_new_order")
     */
    public function index(Request $request, ManagerRegistry $doctrine, ActualCartItemRepository $actualCartItemRepository, OrderRepository $orderRepository): Response
    {

        $form = $this->createForm(NewOrderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newOrder = new Order();
            $newOrder = $form->getData();

            $lastOrderNumber = $orderRepository->findOneBy([], ['orderNumber' => 'DESC'], null, null);
            $incrementedLastOrderNumber = $lastOrderNumber->getOrderNumber() + 1;
            $newOrder->setOrderNumber($incrementedLastOrderNumber);

            $actualCart = $actualCartItemRepository->findAll();
            $totalPrice = 0;

            foreach ($actualCart as $newCartItem) {
                /* convert actualCart to cartItem for adding to order */
                $cartItemToSave = new CartItem;
                $cartItemToSave->setProduct($newCartItem->getProduct());
                $cartItemToSave->setItemQuantity($newCartItem->getItemQuantity());
                $newOrder->addCartItem($cartItemToSave);

                $totalPrice = $totalPrice + $newCartItem->getProduct()->getPrice();
            }
            $newOrder->setPrice($totalPrice);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($newOrder);
            $entityManager->flush();

            /* clear actual cart */
            $actualCartItemRepository->deleteAll();
            return $this->redirectToRoute('admin_orders');
        }

        return $this->render('admin/new/new_order/index.html.twig', [
            'order_form' => $form->createView(),
        ]);
    }
}
