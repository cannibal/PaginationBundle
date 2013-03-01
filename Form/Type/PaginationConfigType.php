<?php
namespace Cannibal\Bundle\PaginationBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaginationConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemsPerPage', 'integer', array('empty_data'=>"15"))
            ->add('current', 'integer', array('empty_data' => "1"));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Cannibal\\Bundle\\PaginationBundle\\Pagination\\PaginationConfig'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'pagination';
    }
}