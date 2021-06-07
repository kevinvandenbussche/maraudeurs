<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudonyme')
            ->add('email', EmailType::class)
            ->add('media', FileType::class,[
                'label'=>'Ajouter votre photo de profil',
                'data_class'=>MediaType::class,
                'mapped'=> false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypesMessage' => 'Veuillez choisir une image au format png ou jpeg',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/png'
                        ]
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
