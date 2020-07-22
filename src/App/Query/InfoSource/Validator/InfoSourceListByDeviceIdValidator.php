<?php

namespace App\App\Query\InfoSource\Validator;

use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQueryInterface;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\App\Query\InfoSource\Validator\InfoSourceListByDeviceIdValidatorInterface
    as GetListValidatorInterface;
use App\Core\Repository\Dictionary\DictionaryQueryRepositoryInterface;
use App\Core\Model\Exception\InvalidDictionaryIdException;

class InfoSourceListByDeviceIdValidator extends BaseCommandValidator implements GetListValidatorInterface
{
    /** @var DictionaryQueryRepositoryInterface */
    private $dictionaryQueryRepository;

    /**
     * InfoSourceListByDeviceIdValidator constructor.
     * @param DictionaryQueryRepositoryInterface $dictionaryQueryRepository
     */
    public function __construct(DictionaryQueryRepositoryInterface $dictionaryQueryRepository)
    {
        $this->dictionaryQueryRepository = $dictionaryQueryRepository;
    }

    /**
     * @param InfoSourceListByDictionaryIdQueryInterface $command
     * @return bool
     * @throws InvalidDictionaryIdException
     */
    public function validate(InfoSourceListByDictionaryIdQueryInterface $command): bool
    {
        /** @var DeviceInterface | null $dictionary */
        $dictionary = $this->dictionaryQueryRepository->find($command->getId());

        if (!$dictionary instanceof DictionaryInterface) {
            $this->errors[] = 'Dictionary is not exist';
        }

        return $this->check();
    }
}
