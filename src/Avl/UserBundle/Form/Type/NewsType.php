<?php

namespace Avl\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use /** @noinspection PhpDeprecationInspection */
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'label.title',
                'required' => true
            ))
            ->add('body', 'textarea', array(
                'label' => 'label.content',
                'attr' => array(
                    'rows' => '10'
                ),
                'required' => true
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'label.news.enabled',
                'required' => false
            ))
            ->add('internal', 'checkbox', array(
                'label' => 'label.internal',
                'required' => false
            ))
            ->add('enabledDate', 'datetime', array(
                'label' => 'label.enabledDate'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Avl\UserBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'avl_newsbundle_news';
    }
}