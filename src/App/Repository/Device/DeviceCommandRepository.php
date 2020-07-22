<?php

namespace App\App\Repository\Device;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Mapper\Device\DeviceModelInterface;
use App\App\Doctrine\Mapper\Dictionary\DictionaryModelToEntityMapperInterface;
use App\App\Doctrine\Mapper\InfoSource\InfoSourceModelToEntityMapperInterface;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Item\InformationItem\Dictionary\Dictionary;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Repository\Device\DeviceCommandRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Model\Exception\InvalidDictionaryIdException;
use PhpCollection\CollectionInterface;

class DeviceCommandRepository implements DeviceCommandRepositoryInterface
{
    /** @var EntityManagerInterface  */
    protected $entityManager;
    /** @var DeviceModelInterface */
    private $deviceModelToEntityMapper;
    /** @var DictionaryModelToEntityMapperInterface */
    private $dictionaryModelToEntityMapper;
    /** @var InfoSourceModelToEntityMapperInterface */
    private $infoSourceModelToEntityMapper;

    /**
     * DeviceCommandRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param DeviceModelInterface $deviceModel
     * @param DictionaryModelToEntityMapperInterface $dictionaryModelToEntityMapper
     * @param InfoSourceModelToEntityMapperInterface $infoSourceModelToEntityMapper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DeviceModelInterface $deviceModel,
        DictionaryModelToEntityMapperInterface $dictionaryModelToEntityMapper,
        InfoSourceModelToEntityMapperInterface $infoSourceModelToEntityMapper
    ) {
        $this->entityManager = $entityManager;
        $this->deviceModelToEntityMapper = $deviceModel;
        $this->dictionaryModelToEntityMapper = $dictionaryModelToEntityMapper;
        $this->infoSourceModelToEntityMapper = $infoSourceModelToEntityMapper;
    }

    /**
     * @param DeviceInterface $device
     * @throws InvalidDictionaryIdException
     */
    public function create(DeviceInterface $device): void
    {
        /** @var DeviceEntity $deviceEntity */
        $deviceEntity = $this->deviceModelToEntityMapper->mapNew($device);

        $dictionary = new Dictionary(
            new DictionaryId($device->getId()->getValue()),
            $device->getName()
        );

        $dictionaryEntity = $this->dictionaryModelToEntityMapper->mapNew($dictionary);

        $this->entityManager->persist($deviceEntity);
        $this->entityManager->persist($dictionaryEntity);

        if ($device->getDynamicFields() && $device->getDynamicFields() instanceof CollectionInterface) {
            foreach ($device->getDynamicFields() as $dynamicField) {
                 $infoSourceEntity = $this->infoSourceModelToEntityMapper->mapByDynamicFieldAndDictionary(
                     $dynamicField,
                     $dictionaryEntity
                 );
                 $this->entityManager->persist($infoSourceEntity);
            }
        }

        $this->entityManager->flush();
    }
}
