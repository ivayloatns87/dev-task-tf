<?php


namespace App\Dto\Response\Transformer;


use App\Dto\Response\ContractResponseDto;
use App\Entity\Contract;

class ContractResponseTransformer extends AbstractResponseDtoTransformer
{

    /**
     * @param Contract $contract
     *
     * @return ContractResponseDto
     */
    public function transformFromObject($contract): ContractResponseDto
    {
        $dto = new ContractResponseDto();
        $dto->contractNumber = $contract->getContractNumber();
        $dto->contractStartDate = $contract->getContractStartDate();

        return $dto;
    }
}