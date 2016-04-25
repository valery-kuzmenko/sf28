<?php
/**
 * Created by PhpStorm.
 * User: Valery.Kuzmenka
 * Date: 4/25/2016
 * Time: 5:06 PM
 */

namespace Yoda\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('email', 'text', array(
                'required' => false,
                'label' => 'Email address',
                'attr' => array(
                    'class' => '3-3PO'
                )
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password' // displays this field two times
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yoda\UserBundle\Entity\User'
        ));
    }


    public function getName()
    {
        return 'user_register';
    }
}