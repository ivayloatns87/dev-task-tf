<?php


namespace App\Form;


use App\Entity\Contract;
use App\Entity\ContractLease;
use App\Entity\ContractOwnership;
use App\Entity\Estate;
use App\Entity\LandOwner;
use App\Factories\EstateFactory;
use App\Form\Subscriber\ContractTypeSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotNull;

class EstateType extends AbstractType
{
    /** @var ContractTypeSubscriber */
    private $contractTypeSubscriber;

    /** @var EstateFactory $estateFactory */
    private $estateFactory;

    /**
     * EstateType constructor.
     * @param ContractTypeSubscriber $contractTypeSubscriber
     * @param EstateFactory $estateFactory
     */
    public function __construct(ContractTypeSubscriber $contractTypeSubscriber, EstateFactory $estateFactory)
    {
        $this->contractTypeSubscriber = $contractTypeSubscriber;
        $this->estateFactory = $estateFactory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('estateNumber', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Estate number can not be null'
                    ]),
                ]
            ])
            ->add('areaInAcre',  MoneyType::class,[
                'constraints' => [
                    new NotNull([
                        'message' => 'Area in acre can not be null'
                    ]),
                ]
            ])
            ->add('landOwners', CollectionType::class,[
                'entry_type' => LandOwnerType::class,
                'mapped' => false,
                'allow_add' => true,
                'constraints' => [
                    //new NotNull(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => Estate::class,
            'allow_extra_fields' => true,
            'empty_data' => function(FormInterface $form) {

                $landOwners = $form->get('landOwners')->getData();
                $estateNumber = $form->get('estateNumber')->getData();
                $areaInAcre = $form->get('areaInAcre')->getData();

                if (!$estateNumber || !$areaInAcre ) {
                    return null;
                }

                //@TODO move in service
                if (count($landOwners) > Estate::SHARE_PERCENTAGE_REQUIRED_OVER_ESTATE_OWNER_COUNT) {
                    /** @var LandOwner $landOwner */
                    $estateSharePercentage = 0;
                    foreach ($landOwners as $landOwner) {

                        if (!$landOwner->getSharePercent()) {
                            $form->get('landOwners')->addError(new FormError("Land Owner share percentage is required"));
                        }
                        $estateSharePercentage += $landOwner->getSharePercent();

                        if ($estateSharePercentage > Estate::MAX_SHARE_PERCENT) {
                            $form->get('landOwners')->addError(new FormError("Estate land owners percentage should not be greater than 100"));
                        }
                    }
                }

                return $this->estateFactory->create($estateNumber, $areaInAcre, $landOwners);
            }
        ]);
    }

}