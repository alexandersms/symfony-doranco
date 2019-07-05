<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
            ->add('price', MoneyType::class, [
                "label" => "Prix"
            ])
            //->add('createAt')
            ->add('isPublished', null, [
                "label" => "Etat de publication"
            ])
            ->add('imageFile', FileType::class, [
                "label" => "Choisir une image"
            ])
            //->add('slug')
            //->add('tags')
            ->add('categories', null, [
                "label" => "Catégorie associée"
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
