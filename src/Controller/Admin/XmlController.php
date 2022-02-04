<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\CartItem;
use Doctrine\Persistence\ManagerRegistry;


class XmlController extends AbstractController
{
    /**
     * @Route("/admin/xml", name="admin_xml")
     */
    public function insertXmlToDatabase(): Response
    {
        $entityManager = $this->doctrine->getManager();
        $xml = simplexml_load_file("orders.xml") or die("Error: Cannot create object");

        $countAddedCustomersInDatabase = 0;
        $countAddedProductsInDatabase = 0;
        $countAddedOrdersInDatabase = 0;

        foreach ($xml->children() as $row) {
            $order = new Order();
            $order->setOrderNumber(intval($row->attributes()->id));

            /* create customer and save customer only if not exist*/
            $customerXml = $row->customer;
            $customersInDatabase = $entityManager->getRepository(Customer::class)->findOneBy(['firstname' => $customerXml->firstname, 'lastname' => $customerXml->lastname]);

            if (is_null($customersInDatabase)) {
                $customer = new Customer();
                $customer->setFirstname($customerXml->firstname);
                $customer->setLastname($customerXml->lastname);
                $this->save($customer);
                $countAddedCustomersInDatabase++;
            } else {
                $customer = $customersInDatabase;
            }

            $cart = $row->cart;
            foreach ($cart as $item) {
                foreach ($item as $productXml) {

                    /* create product and save product only if not exist */
                    $productInDatabase = $entityManager->getRepository(Product::class)->findOneBy(['sku' => $productXml->attributes()->sku]);
                    if (is_null($productInDatabase)) {
                        $product = new Product();
                        $product->setSku($productXml->attributes()->sku);
                        $product->setName($productXml->name);
                        $product->setPrice(intval($productXml->price));
                        $this->save($product);
                        $countAddedProductsInDatabase++;
                    } else {
                        $product = $productInDatabase;
                    }

                    /* add product to cart */
                    $cartItem = new CartItem();
                    $cartItem->setItemQuantity(intval($productXml->quantity));
                    $cartItem->setProduct($product);
                    $cartItem->setOrderNumber($order);

                    /* add cart item to order */
                    $order->addCartItem($cartItem);
                }
            }

            /* create and save (if not exist) the order containing customer information, cart products and order's information */
            $orderInDatabase =  $entityManager->getRepository(Order::class)->findOneBy(['orderNumber' => $order->getOrderNumber()]);
            if (is_null($orderInDatabase)) {
                $order->setStatus($row->status);
                $order->setDate(new \DateTime($row->orderDate));
                $order->setPrice(intval($row->price));
                $order->setCustomer($customer);
                $this->save($order);
                $countAddedOrdersInDatabase++;
            }
        }

        return $this->render('admin/xml/index.html.twig', [
            'countAddedOrdersInDatabase' => $countAddedOrdersInDatabase,
            'countAddedCustomersInDatabase' =>  $countAddedCustomersInDatabase,
            'countAddedProductsInDatabase' =>  $countAddedProductsInDatabase,
        ]);
    }

    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function save($entity)
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }
}
