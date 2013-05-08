<?php
namespace Cannibal\Bundle\PaginationBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaginatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('perPage', 'integer', array('empty_data'=>"15"))
            ->add('page', 'integer', array('empty_data' => "1"));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Cannibal\\Bundle\\PaginationBundle\\Pagination\\Paginator\\Paginator'
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