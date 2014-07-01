<?php
/*
 * Copyright (c) 2014 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */
namespace Eltrino\DiamanteDeskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BranchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            array(
                'label'    => 'Name',
                'required' => true,
            )
        );

        $builder->add(
            'description',
            'textarea',
            array(
                'label'    => 'Description',
                'required' => false,
            )
        );

        $builder->add(
            'logoFile',
            'file',
            array(
                'label'    => 'Image',
                'required' => false,
                'tooltip' => 'The Image must be in JPEG or PNG formats',
                'attr' => array(
//                    "accept" => "image/*",
//                    'multiple' => 'multiple'
                )
            )
        );

        // tags
        $builder->add(
            'tags',
            'oro_tag_select',
            array(
                'label' => 'oro.tag.entity_plural_label'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Eltrino\DiamanteDeskBundle\Form\Command\BranchCommand',
                'intention' => 'branch',
                'cascade_validation' => true
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'diamante_branch_form';
    }
}