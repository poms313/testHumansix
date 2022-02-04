<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CustomerRepository;
use Symfony\Component\Serializer\SerializerInterface;

class CustomersController extends AbstractController
{
    public function __construct(CustomerRepository $customerRepository, SerializerInterface $serializer)
    {
        $this->customerRepository = $customerRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/customers", name="api_customers", methods={"GET","HEAD"})
     */
    public function getAllcustomers(): Response
    {
        $customersList = $this->customerRepository->findAll();
        $dataToEncode = array();

        /* convert each customer into array */
        foreach ($customersList as $customerInDatase) {
            $customerToEncode = $this->convertToArray($customerInDatase);
            array_push($dataToEncode, $customerToEncode);
        }
        /* convert array to json content */
        $jsonContent = $this->serializer->serialize($dataToEncode, 'json');

        return $this->render('api/api.html.twig', [
            'jsonContent' => $jsonContent,
        ]);
    }

    /**
     * @Route("/api/customer/{id}", methods={"GET","HEAD"})
     * @param string $id
     */
    public function getcustomerById($id)
    {
        $customerInDatase = $this->customerRepository->findOneBy(['id' => $id]);

        if (is_null($customerInDatase)) {
            $jsonContent = null;
        } else {
            /* convert customer into array */
            $dataToEncode = $this->convertToArray($customerInDatase);
            /* convert array to json content */
            $jsonContent = $this->serializer->serialize($dataToEncode, 'json');
        }
        return $this->render('api/api.html.twig', [
            'jsonContent' => $jsonContent,
        ]);
    }

    public function convertToArray($customer)
    {
        $customerToEncode = array();
        $customerToEncode['firstName'] = $customer->getFirstname();
        $customerToEncode['price'] = $customer->getLastname();
        $customerToEncode['id'] = $customer->getId();
        return $customerToEncode;
    }
}
