<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProductRepository;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
    public function __construct(ProductRepository $productRepository, SerializerInterface $serializer)
    {
        $this->productRepository = $productRepository;
        $this->serializer = $serializer;
    }

    /** 
     * @Route("/api/products", name="api_products", methods={"GET","HEAD"})
     */
    public function getAllproducts(): Response
    {
        $productsList = $this->productRepository->findAll();
        $dataToEncode = array();

        /* convert each product into array */
        foreach ($productsList as $productInDatase) {
            $productToEncode = $this->convertToArray($productInDatase);
            array_push($dataToEncode, $productToEncode);
        }
        /* convert array to json content */
        $jsonContent = $this->serializer->serialize($dataToEncode, 'json');

        return $this->render('api/api.html.twig', [
            'jsonContent' => $jsonContent,
        ]);
    }

    /**
     * @Route("/api/product/{id}", methods={"GET","HEAD"})
     * @param string $id
     */
    public function getproductById($id)
    {
        $productInDatase = $this->productRepository->findOneBy(['id' => $id]);

        if (is_null($productInDatase)) {
            $jsonContent = null;
        } else {
            /* convert product into array */
            $dataToEncode = $this->convertToArray($productInDatase);
            /* convert array to json content */
            $jsonContent = $this->serializer->serialize($dataToEncode, 'json');
        }
        return $this->render('api/api.html.twig', [
            'jsonContent' => $jsonContent,
        ]);
    }

    public function convertToArray($product)
    {
        $productToEncode = array();
        $productToEncode['name'] = $product->getName();
        $productToEncode['price'] = $product->getPrice();
        $productToEncode['id'] = $product->getId();
        $productToEncode['sku'] = $product->getSku();
        return $productToEncode;
    }
}
