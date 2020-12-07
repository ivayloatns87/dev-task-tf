<?php


namespace App\Form;


use App\Entity\Contract;
use App\Entity\ContractLease;
use App\Entity\ContractOwnership;
use App\Form\Subscriber\ContractTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ContractType extends AbstractType
{
    /** @var ContractTypeSubscriber */
    private $contractTypeSubscriber;

    public function __construct(ContractTypeSubscriber $contractTypeSubscriber)
    {
        $this->contractTypeSubscriber = $contractTypeSubscriber;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contractNumber', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Contract number can not be blank',
                    ]),
                ]
            ])
            ->add('type',  IntegerType::class,[
                'constraints' => [
                    new NotNull(),
                ]
            ])
            ->add('contractStartDate', TextType::class,[
                'constraints' => [
                     new NotNull(),
                ]
            ])
            ->add('estates', CollectionType::class,[
                'entry_type' => EstateType::class,
                'mapped' => false,
                'allow_add' => true,
                'constraints' => [
                    new NotNull(),
                ]
            ])

        ;

        $builder->addEventSubscriber($this->contractTypeSubscriber);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => Contract::class,
            'allow_extra_fields' => true,
            'empty_data' => function (FormInterface $form) {

                $contractNumber =  $form->get('contractNumber')->getData();
                $contractType =  $form->get('type')->getData();
                $contractStartDate =  $form->get('contractStartDate')->getData();

                if (!$contractNumber || !$contractType || !$contractStartDate){
                    return null;
                }


                if ($contractType == Contract::CONTRACT_LEASE_TYPE) {
                    $contractEndDate = $form->get('contractEndDate')->getData();
                    $rent = $form->get('rentPerAcre')->getData();

                    if (!$rent || !$contractEndDate) {
                        return null;
                    }

                    return new ContractLease($contractNumber, $contractType, $contractStartDate, $contractEndDate, $rent);
                } else {
                    $price = $form->get('price')->getData();

                    if (!$price) {
                        return null;
                    }
                    return new ContractOwnership($contractNumber, $contractType, $contractStartDate, $price);
                }
            }
        ]);
    }
}