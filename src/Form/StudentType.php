<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Classroom;
use Doctrine\ORM\Mapping\Entity;
use PhpParser\Builder\Class_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt')
            ->add('name')
            ->add('age')
            ->add('email')
            ->add('st',EntityType::class,['class' =>Classroom::class,
           'choice_label' =>'name',
            'label'=>'Classroom'])
        ;



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
