<?php

namespace App\Form\Type;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionFormType extends AbstractType
{

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextType::class);
        $builder->add('createdAt', TextType::class);

        $builder->add(
            'choices',
            CollectionType::class,
            [
                'entry_type'   => ChoiceFormType::class,
                'allow_add'    => true,
                'allow_delete' => false,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(
            [
                'data_class'      => Question::class,
                'csrf_protection' => false,
            ]
        );
    }

}
