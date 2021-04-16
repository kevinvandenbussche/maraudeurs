<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\CategoryArticle;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //add correspond au ligne de mon formulaire qui eu meme corresponde au champ de mon entité
        $builder
            ->add('articleContent')
            ->add('title')
            //je precise a symfony que ce champ est une entité
            ->add('category', EntityType::class,[
                //je lui indique que c'est l'entité categoryArticle
                'class' => CategoryArticle::class,
                //et qui correspond au champ name de mon entité
                'choice_label'=> 'name'
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'user'
            ])
            //j'indique a symfony que mon l'objet qu'il recoit est un tableau
            ->add('media', CollectionType::class, [
                //je lui indique se qu'il va recevoir comme type de valeur
                'entry_type' => MediaType::class,

            ])
//            ->add('media', MediaType::class)
//            ->add('media', FileType::class, [
//                'label' => 'media',
//                'required' => false,
//                'mapped' => false,
//                'constraints' => [
//                    new File([
//                        'maxSize' => '1024k',
//                        'mimeTypes' => [
//                            'application/pdf',
//                            'application/x-pdf',
//                        ],
//                        'mimeTypesMessage' => 'Veuillez télécharger des fichiers de type PDF',
//                    ])
//                ],
//            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
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
