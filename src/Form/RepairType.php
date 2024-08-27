<?php

namespace App\Form;

use DateTime;
use App\Entity\Repair;
use App\Entity\Equipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RepairType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startRepairDate', DateType::class, [
                'widget' => 'single_text',
                'data' => $options['default_date']
            ])
            ->add('endRepairDate', DateType::class, [
                'widget' => 'single_text',
                'data' => $options['default_date']
            ])
            ->add('actualRepairDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('equipment', EntityType::class, [
                'class' => Equipment::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Repair::class,
            'default_date' => new DateTime(),
        ]);
    }
}
