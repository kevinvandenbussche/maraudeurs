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
        //add correspond au ligne de mon formulaire qui elles mêmes correspondent au champ de mon entité
        $builder
            ->add('title')
            ->add('articleContent')
            //je precise a symfony que ce champ est une entité
            ->add('categoryArticle', EntityType::class,[
                //je lui indique que c'est l'entité categoryArticle
                'class' => CategoryArticle::class,
                //et qui correspond au champ name de mon entité
                'choice_label'=> 'name'
            ])
            //j'indique à Symfony qu'il va recevoir des fichiers
            ->add('media', FileType::class,[
                'label' => 'Joindre votre(ou vos) document(s)',
                'data_class' => Media::class,
                //je lui dit qu'il ne doit pas s'occuper du deplacement du fichier
                'mapped' => false,
                'required' => false,
                //je lui indique quel type de fichier il doit recevoir
                'constraints' => [
                            new File([
                                'maxSize' => '50M',
                                'mimeTypesMessage' => 'Veuillez choisir un document au format pdf ou pptx',
                                'mimeTypes' => [
                                    'application/pdf',
                                    'application/x-pdf',
                                    'application/vnd.ms-powerpoint',
                                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                ]
                            ]),
                        ],
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
