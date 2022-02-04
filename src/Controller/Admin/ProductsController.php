<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProductRepository;


class ProductsController extends AbstractController
{
    /**
     * @Route("/admin/products", name="admin_products")
     */
    public function index(ProductRepository $productRepository): Response
    {

        $productsList = $productRepository->findAll();
        return $this->render('admin/products/index.html.twig', [
            'productsList' => $productsList,
        ]);
    }
}
