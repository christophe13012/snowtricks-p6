<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => array(
                    new NotBlank(array("message" => "Merci d'entrer un nom d'utilisateur")),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre nom doit contenir plus de {{ limit }} caractères',
                        'max' => 20,
                        'maxMessage' => 'Votre nom doit contenir moins de {{ limit }} caractères',
                    ])
                )
            ])
            ->add('email', EmailType::class, [
                'constraints' => array(
                    new NotBlank(array("message" => "Merci d'entrer un email")),
                    new Email(array("message" => "Votre email ne semble pas valide")),
                )
            ])
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir plus de {{ limit }} caractères',
                        'max' => 20,
                        'maxMessage' => 'Votre mot de passe doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
