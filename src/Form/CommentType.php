<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Product;
use DateTime;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author' , TextType::class ,[
                'label'=> 'Votre pseudo',
                'attr'=>[
                    'class'=> 'form-control'
                ]
  
              ])
           // ->add('datecomment')
            ->add('email' , EmailType::class ,[
              'label'=> 'Votre e-mail',
              'attr'=>[
                  'class'=> 'form-control'
              ]

            ])
            ->add('content', TextareaType::class ,[
                'label'=> 'Votre Comment',
                'attr'=>[
                    'class'=> 'form-control'
                ]
  
              ])
            ->add('productid' , HiddenType::class,[
                'mapped'=>false
            ])
            ->add('isPublished')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
