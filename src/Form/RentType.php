<?php

namespace App\Form;

use App\Entity\Equipment;
use App\Entity\Rent;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startRentDate', DateType::class, [
                'widget' => 'single_text',
                'data' => $options['default_date'],
            ])
            ->add('endRateDate', DateType::class, [
                'widget' => 'single_text',
                'data' => $options['default_date'],
            ])
            ->add('price', MoneyType::class, [
                'currency' => 'pln',
                'disabled' => true,
            ])
            ->add(
                'discount',
                MoneyType::class,
                [
                'currency' => 'pln',
                'disabled' => true,
            ]
            )
            ->add(
                'final_price',
                MoneyType::class,
                [
                'currency' => 'pln',
                'disabled' => true,
            ]
            )
            ->add('equipment', EntityType::class, [
                'class' => Equipment::class,
                'choice_label' => 'name',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                    ->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
                    ->setParameter('role', '"ROLE_USER"')
                    ->orderBy('u.email', 'ASC');
                },
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rent::class,
            'default_date' => new DateTime()
        ]);
    }
}
