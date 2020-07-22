<?php

namespace App\App\Mapper\Division;

use App\App\Doctrine\Entity\Division as DivisionORM;
use App\Core\Model\Division\Division;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\Exception\InvalidDivisionIdException;

class DoctrineEntityDivisionMapper
{
    /**
     * @param DivisionORM $divisionORM
     * @return Division|null
     * @throws InvalidDivisionIdException
     */
    public function map(DivisionORM $divisionORM): ?Division
    {
        if (!$divisionORM instanceof DivisionORM) {
            return null;
        }

        /** @var Division $division */
        $division = new Division(
            new DivisionId($divisionORM->getId()),
            $divisionORM->getAlias(),
            $divisionORM->getName()
        );

        $division->setDescription($divisionORM->getDescription());

        return $division;
    }
}
