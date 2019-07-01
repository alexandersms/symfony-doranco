<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                "label" => "Nom"
            ])
            ->add('description', null, [
                "label" => "Description"
            ])
            //->add('nbViews')
            ->add('price', null, [
                "label" => "Prix"
            ])
            //->add('createAt')
            ->add('isPublished', null, [
                "label" => "Etat de publication"
            ])
            ->add('imageName', null, [
                "label" => "Image à définir"
            ])
            //->add('slug')
            //->add('tags')
            ->add('categories', null, [
                "label" => "Catégories"
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Créer un produit"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
