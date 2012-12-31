<?php

namespace Rizeway\RizewayWallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text');
        $builder->add('description', 'text');
        $builder->add('photo', 'file');
        $builder->add('link', 'url');
        $builder->add('email', 'email');
    }

    public function getName()
    {
        return 'element';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Rizeway\RizewayWallBundle\Entity\Element',
        );
    }
}