<?php

namespace App\App\Handler\InfoSource;

use App\App\Query\InfoSource\Validator\InfoSourceListByDeviceIdValidatorInterface;
use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQueryInterface;
use App\Core\Repository\InfoSource\InfoSourceQueryRepositoryInterface;
use App\Infrastructure\Exception\InfoSource\FailGetInfoSourceListByDictionaryId;
use PhpCollection\CollectionInterface;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetInfoSourceQueryHandler implements MessageHandlerInterface
{
    /** @var InfoSourceListByDeviceIdValidatorInterface */
    private $getInfoSourceListByDeviceIdValidator;
    /** @var InfoSourceQueryRepositoryInterface */
    private $infoSourceQueryRepository;

    /**
     * GetInfoSourceQueryHandler constructor.
     * @param InfoSourceListByDeviceIdValidatorInterface $getDeviceDynamicFieldListByDeviceIdValidator
     * @param InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
     */
    public function __construct(
        InfoSourceListByDeviceIdValidatorInterface $getDeviceDynamicFieldListByDeviceIdValidator,
        InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
    ) {
        $this->getInfoSourceListByDeviceIdValidator = $getDeviceDynamicFieldListByDeviceIdValidator;
        $this->infoSourceQueryRepository = $infoSourceQueryRepository;
    }

    /**
     * @param InfoSourceListByDictionaryIdQueryInterface $command
     * @return CollectionInterface|null
     * @throws FailGetInfoSourceListByDictionaryId
     */
    public function __invoke(InfoSourceListByDictionaryIdQueryInterface $command): ?CollectionInterface
    {
        try {
            if (!$this->getInfoSourceListByDeviceIdValidator->validate($command)) {
                throw new FailGetInfoSourceListByDictionaryId(
                    $this->getInfoSourceListByDeviceIdValidator->getFirstErrorMessage()
                );
            }

            return $this->infoSourceQueryRepository->findAllByDictionaryId($command->getId());
        } catch (Exception $exception) {
            throw new FailGetInfoSourceListByDictionaryId($exception->getMessage());
        }
    }
}
