<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Products;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('prix')
            ->add('image')
            ->add('categorie', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'categorie',
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'service',
            ])
            // ->add('orders', EntityType::class, [
            //     'class' => Order::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
