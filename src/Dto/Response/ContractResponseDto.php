<?php


namespace App\Dto\Response;

use JMS\Serializer\Annotation as Serialization;

class ContractResponseDto
{
    /**
     * @Serialization\Type("string")
     */
    public $contractNumber;

    /**
     * @Serialization\Type ("string")
     */
    public $contractStartDate;

}