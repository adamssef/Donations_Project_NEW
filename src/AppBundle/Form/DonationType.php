<?php


namespace AppBundle\Form;

use AppBundle\Entity\Donation;
use AppBundle\Entity\Category;
use AppBundle\Entity\Institution;
use AppBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true
            ]);
        $builder->add('institution', EntityType::class, [
            'class' => Institution::class,
            'expanded' => true,
            'multiple' => false
        ])
            ->add('quantity', IntegerType::class)
            ->add('street', TextType::class)
            ->add('city', TextType::class)
            ->add('zipCode', TextType::class)
            ->add('pickUpDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('pickUpTime', TimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker']
            ]);
        $builder
            ->add('pickUpComment', TextType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}