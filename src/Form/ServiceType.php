<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Service;
use App\Entity\ServiceStage;
use App\Entity\ServiceType as EntityServiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('details', TextareaType::class, [
                'label' => 'Detalles',
            ])            
            ->add('is_billable', CheckboxType::class, [
                'required' => false,
                'label' => 'Es Facturable',
            ])            
            ->add('is_served', CheckboxType::class, [
                'required' => false,
                'label' => 'Fue atendido',
            ])            
            ->add('service_type', EntityType::class, [
                'class' => EntityServiceType::class,
                'choice_label' => 'name',
                'label' => 'Tipo de Servicio',
            ])            
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',
                'label' => 'Cliente',
            ])            
            ->add('due_date', DateTimeType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                // 'html5' => false,
                'attr' => [
                    'type' => 'datetime',
                ],
                'label' => 'Fecha de la Cita',
            ])
            ->add('service_stage', EntityType::class, [
                'class' => ServiceStage::class,
                'choice_label' => 'name',
                'label' => 'Fase del servicio',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
