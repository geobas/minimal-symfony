<?php

namespace Custom\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'My title',
                'attr' => array('style' => 'color:blue')
            ))
            ->add('content')
            ->add('category')
        ;
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view['title']->vars['help'] = 'Plz give a title';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Custom\CMSBundle\Entity\Page'
        ));
    }
}
