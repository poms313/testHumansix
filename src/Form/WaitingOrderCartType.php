<?php

namespace App\Form;

use App\Entity\WaitingOrderCart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;




class WaitingOrderCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('itemQuantity', NumberType::class, array(
                'required'   => true,
                'attr' => [
                    'min' => 1,
                    'max' => 20,
                    'step' => 1,
                    'value' => 1
                ],
            ))
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'required'   => true,
                'multiple' => false,
                'expanded' => true,
                'choice_label' => function (Product $product) {
                    return sprintf('%s, %s€, (%s)', $product->getName(), $product->getPrice(), $product->getSku());
                }
            ])
            ->add('addCartItem', SubmitType::class, [
                'label' => 'Ajouter au panier',
                'attr' => [
                    'name' => 'addCartItem',
                    'class' => 'custom-btn button'
                ],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WaitingOrderCart::class,
        ]);
    }
}
