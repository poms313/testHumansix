<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\CartItem;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Schema\Constraint;



class XmlController extends AbstractController
{
    /**
     * @Route("/xml", name="xml")
     */
    public function insertXmlToDatabase(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $xml = simplexml_load_file("orders.xml") or die("Error: Cannot create object");

        $countAddedRowsInDatabase = 0;

        foreach ($xml->children() as $row) {
            $order = new Order();

            /* create and save customer */
            $customerXml = $row->customer;
            $customer = new Customer();
            $customer->setFirstname($customerXml->firstname);
            $customer->setLastname($customerXml->lastname);
            /* save customer only if not exist */
            $customersInDatabase = $entityManager->getRepository(Customer::class)->findOneBy(array('id' => $customerXml["id"]), null);
            if (is_null(empty($customersInDatabase))) {
                $entityManager->persist($customer);
                $entityManager->flush();
                $countAddedRowsInDatabase++;
            }

            $cart = $row->cart;
            foreach ($cart as $item) {
                foreach ($item as $productXml) {

                    /* create and save product */
                    $product = new Product();
                    $product->setSku($productXml->attributes()->sku);
                    $product->setName($productXml->name);
                    $product->setPrice(intval($productXml->price));
                    /* save product only if not exist */
                    $productInDatabase = $entityManager->getRepository(Product::class)->findOneBy(array('sku' => $productXml->sku), null);
                    if (is_null(empty($productInDatabase))) {
                        $entityManager->persist($product);
                        $entityManager->flush();
                        $countAddedRowsInDatabase++;
                    }
                    
                    /* create and save the products in the cart with quantity */
                    $cartItem = new CartItem();
                    $cartItem->setItemQuantity(intval($productXml->quantity));
                    $cartItem->setProduct($product);
                    $cartItem->setOrderId($order);
                    /* save cart item if not exist */
                    $cartItemInDatabase = $entityManager->getRepository(CartItem::class)->findOneBy(array('orderId' => $order->getOrderId()), null);
                    if (is_null(empty($cartItemInDatabase))) {
                        $entityManager->persist($cartItem);
                        $entityManager->flush();
                        $countAddedRowsInDatabase++;
                    }
                }
            }

            /* create and save the order containing customer information, cart products and order's information */
            $order->setOrderId(intval($row->attributes()->id));
            $order->setStatus($row->status);
            $order->setDate(new DateTime($row->orderDate));
            $order->setPrice(intval($row->price));
            /* save order if not exist */
            $orderInDatabase =  $entityManager->getRepository(Order::class)->findOneBy(array('orderId' => $order->getOrderId()), null);
            if (is_null(empty($orderInDatabase))) {
                $entityManager->persist($order);
                $entityManager->flush();
                $countAddedRowsInDatabase++;
            }
        }

        if ($countAddedRowsInDatabase > 0) {
            $message = $countAddedRowsInDatabase . " lignes ont été insérées dans la base de donnée";
        } else {
            $message = "Pas de modifications de la base de donnée, le fichier est déjà chargé";
        }

        return $this->render('xml/index.html.twig', [
            'message' => $message,
        ]);
    }
}
