<?php

namespace App\Core\Model\Facility;

use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelId;

class FacilityId extends ModelId
{
    /**
     * FacilityId constructor.
     * @param string $value
     * @throws InvalidFacilityIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidFacilityIdException('Invalid FacilityId given');
        }
    }
}
