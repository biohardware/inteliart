<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\User;
use Doctrine\DBAL\Types\IntegerType;
use function PHPSTORM_META\type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'form.user.email',
                'attr' => [
                    'autocomplete' => 'off'
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Ezt nem lehet üres']),
                    new Assert\Email(['checkHost' => true, 'message' => 'email_error']),
                ]
            ])
            ->add('active', CheckboxType::class, [
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ],
                'multiple' => true
            ])
            ->add('readable_news', EntityType::class, [
                'multiple' => true,
                'expanded' => true,
                'placeholder' => 'válassz usert',
                'class' => News::class,
                'choice_label' => 'title',

            ])
            ->add('submit_btn', SubmitType::class, [
                'label' => 'mentés'
            ]);
        if ($options['edit']) {
            $builder->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Valami hiba történt!',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'empty_data' => '',
                'attr' => ['autocomplete' => 'new-password']
            ]);

        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'site',
            'edit' => true,
            'constraints' => array(
                new UniqueEntity(array('fields' => array('email')))),
        ]);
    }
}
