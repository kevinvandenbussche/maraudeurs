<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\CategoryArticle;
use App\Entity\Media;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //add correspond au ligne de mon formulaire qui eu meme corresponde au champ de mon entité
        $builder
            ->add('articleContent')
            ->add('title')
            //je precise a symfony que ce champ est une entité
            ->add('categoryArticle', EntityType::class,[
                //je lui indique que c'est l'entité categoryArticle
                'class' => CategoryArticle::class,
                //et qui correspond au champ name de mon entité
                'choice_label'=> 'name'
            ])
            //j'indique a symfony que mon l'objet qu'il recoit est un tableau
            ->add('media', CollectionType::class, [
                //je lui indique se qu'il va recevoir comme type de valeur
                'entry_type' => MediaType::class,

            ])
//            ->add('media', MediaType::class)
            ->add('media', FileType::class,[
                'label' => 'Joindre votre(ou vos) document(s)',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '50M',
                                'mimeTypesMessage' => 'Veuillez choisir un document au format pdf',
                                'mimeTypes' => [
                                    'application/pdf',
                                    'application/x-pdf'
                                ]
                            ]),
                        ],
                    ]),
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
