<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Equipment;
use App\Enum\EquipmentDimension;
use App\Enum\EquipmentStatus;
use App\Enum\EquipmentType as EquipmentTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

final class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('status', EnumType::class, ['class' => EquipmentStatus::class])
            ->add('price', MoneyType::class, [
                'currency' => '',
            ])
            ->add(
                'dimension',
                EnumType::class,
                [
                'class' => EquipmentDimension::class,
                ]
            )
            ->add('type', EnumType::class, [
                'class' => EquipmentTypeEnum::class
                ])
            ->add('img', FileType::class, [

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'extensions' => [
                            'jpeg',
                            'png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                    ],
                    'data_class' => null
                //'required' => false,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
