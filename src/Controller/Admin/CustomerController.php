<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CustomerRepository;

class CustomerController extends AbstractController
{
    /**
     * @Route("/admin/customers", name="admin_customers")
     */
    public function index(CustomerRepository $customerRepository): Response
    {

        $customersList = $customerRepository->findAll();
        return $this->render('admin/customers/index.html.twig', [
            'customersList' => $customersList,
        ]);
    }
}
