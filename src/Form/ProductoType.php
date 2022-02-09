<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class)
            ->add('subtitulo', TextType::class)
            ->add('descripcion', TextareaType::class)
            ->add('categoria', EntityType::class, ['class' => Categoria::class])
            ->add('precio', NumberType::class
                , array(
                'scale' => 1,
                'attr' => array(
                    'min' => 0,
                    'max' => 1000,
                    'step' => '.01',
                ))
            )
//            ->add('fecha', DateType::class, ['widget' => 'single_text'])
            ->add('imagen', FileType::class, ['data_class' => null, 'label' => 'Imagen (JPG o PNG):'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
