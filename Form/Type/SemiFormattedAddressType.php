<?php
/*
 * This file is part of the Badcow Address Bundle.
 *
 * (c) Samuel Williams <sam@badcow.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Badcow\AddressBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SemiFormattedAddressType extends AbstractType
{
    /**
     * @var null|array
     */
    protected $states;

    /**
     * @param array|null $states
     */
    public function __construct(array $states = null)
    {
        $this->states = $states;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', 'textarea')
            ->add('locality', 'text', array(
                'label' => 'Town/City/Suburb',
            ));
        $this->addStatesField($builder)
            ->add('postcode', 'text', array(
                'label' => 'Postal/Zip Code',
            ))
            ->add('country', 'country', array(
                'empty_value' => 'Select Country',
            ))
        ;
    }

    /**
     * @param FormBuilderInterface $builder
     * @return FormBuilderInterface
     */
    protected function addStatesField(FormBuilderInterface $builder)
    {
        $type = 'text';
        $options = array(
            'label' => 'State/Province',
        );

        if (null !== $this->states) {
            $type = 'choice';
            $options = array_merge($options, array(
                'expanded' => false,
                'multiple' => false,
                'choices' => $this->states,
                'empty_value' => 'Select State',
            ));
        }

        return $builder->add('state', $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "badcow_address_semiformatted";
    }
}