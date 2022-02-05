<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Customer;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NewOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, array(
                'label' => 'Date',
                'data' => new \DateTime()
            ))
            
            ->add('customer', EntityType::class, [
                'label' => 'Nom de l\'utilisateur',
                'class' => Customer::class,
                'required'   => true,
                'choice_label' => function(Customer $customer) {
                    return sprintf('%s %s', $customer->getFirstName(), $customer->getlastName());
                }
            ])
            ->add('status', ChoiceType::class, array(
                'choices'  => [
                    'En cours' => 'processing',
                    'Annulée' => 'canceled',
                    'En pause' => 'paused',
                ]
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'button-bird-text']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
