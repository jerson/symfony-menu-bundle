<?php

namespace MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NameType extends AbstractType
{

    public function getParent()
    {
        return TextType::class;
    }

    public function getName()
    {
        return 'name';
    }


}