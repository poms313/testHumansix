<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\OrderRepository;
use Symfony\Component\Serializer\SerializerInterface;

class OrdersController extends AbstractController
{
    public function __construct(OrderRepository $orderRepository, SerializerInterface $serializer)
    {
        $this->orderRepository = $orderRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/orders", name="api_orders", methods={"GET","HEAD"})
     */
    public function getAllOrders(): Response
    {
        $ordersList = $this->orderRepository->findAll();
        $dataToEncode = array();

        /* convert each order into array */
        foreach ($ordersList as $orderInDatase) {
            $orderToEncode = $this->convertToArray($orderInDatase);
            array_push($dataToEncode, $orderToEncode);
        }
        /* convert array to json content */
        $jsonContent = $this->serializer->serialize($dataToEncode, 'json');

        return $this->render('api/api.html.twig', [
            'jsonContent' => $jsonContent,
        ]);
    }

    /**
     * @Route("/api/order/{id}", methods={"GET","HEAD"})
     * @param string $id
     */
    public function getOrderById($id)
    {
        $orderInDatase = $this->orderRepository->findOneBy(['orderNumber' => $id]);
        if (is_null($orderInDatase)) {
            $jsonContent = null;
        } else {
            /* convert order into array */
            $dataToEncode = $this->convertToArray($orderInDatase);
            /* convert array to json content */
            $jsonContent = $this->serializer->serialize($dataToEncode, 'json');
        }
        return $this->render('api/api.html.twig', [
            'jsonContent' => $jsonContent,
        ]);
    }

    public function convertToArray($order)
    {
        $orderToEncode = array();

        $customerToEncode = array();
        $customerToEncode['firstName'] = $order->getCustomer()->getFirstname();
        $customerToEncode['lastName'] = $order->getCustomer()->getLastname();
        $customerToEncode['id'] = $order->getCustomer()->getId();
        $orderToEncode['customer'] = $customerToEncode;

        $orderToEncode['date'] = $order->getDate();
        $orderToEncode['status'] = $order->getStatus();
        $orderToEncode['price'] = $order->getPrice();
        $orderToEncode['orderNumber'] = $order->getOrderNumber();

        foreach ($order->getCartItem() as $cartItem) {
            $cartItemToEncode = array();
            $cartItemToEncode['itemQuantity'] = $cartItem->getItemQuantity();
            $productToEncode = array();
            $productToEncode['name'] = $cartItem->getProduct()->getName();
            $productToEncode['price'] = $cartItem->getProduct()->getPrice();
            $productToEncode['id'] = $cartItem->getProduct()->getId();
            $productToEncode['sku'] = $cartItem->getProduct()->getSku();
            $cartItemToEncode['product'] = $productToEncode;
            $orderToEncode['cartItem'] = $cartItemToEncode;
        }
        return $orderToEncode;
    }
}
