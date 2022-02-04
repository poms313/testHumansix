<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\OrderRepository;

class OrdersController extends AbstractController
{
    /**
     * @Route("/admin/orders/{critera}/{direction}",
     *  name="admin_orders",  
     *  defaults={"critera" = "date", "direction" = "ASC"})
     *  @param string $critera
     *  @param string $direction
     */
    public function index($critera, $direction,  OrderRepository $OrderRepository): Response
    {
        $ordersList = $OrderRepository->findBy([], [$critera =>$direction], null, null); 

        return $this->render('admin/orders/index.html.twig', [
           'ordersList' => $ordersList,
           'critera' => $critera,
           'direction' => $direction,
        ]);
    }
}
