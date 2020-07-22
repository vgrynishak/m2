<?php

namespace App\App\Handler\Paragraph;

use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\App\Command\Paragraph\Validator\CreateRootWithoutDeviceValidatorInterface;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Service\Paragraph\PositionIteratorInterface;
use App\Infrastructure\Exception\Paragraph\FailCreateRootWithoutDevice;
use Exception;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use App\App\Command\Paragraph\Mapper\ParagraphMapperByCommandInterface;

class CreateRootWithoutDeviceHandler
{
    /** @var ParagraphCommandRepositoryInterface */
    protected $repository;
    /** @var CreateRootWithoutDeviceValidatorInterface */
    protected $validator;
    /** @var PositionIteratorInterface */
    private $positionIterator;
    /** @var ParagraphMapperByCommandInterface */
    private $paragraphMapper;

    /**
     * CreateRootWithoutDeviceHandler constructor.
     * @param ParagraphCommandRepositoryInterface $repository
     * @param ParagraphMapperByCommandInterface $paragraphMapper
     * @param CreateRootWithoutDeviceValidatorInterface $validator
     * @param PositionIteratorInterface $positionIterator
     */
    public function __construct(
        ParagraphCommandRepositoryInterface $repository,
        ParagraphMapperByCommandInterface $paragraphMapper,
        CreateRootWithoutDeviceValidatorInterface $validator,
        PositionIteratorInterface $positionIterator
    ) {
        $this->repository = $repository;
        $this->paragraphMapper = $paragraphMapper;
        $this->validator = $validator;
        $this->positionIterator = $positionIterator;
    }

    /**
     * @param CreateRootWithoutDeviceCommandInterface $command
     * @throws FailCreateRootWithoutDevice
     */
    public function __invoke(CreateRootWithoutDeviceCommandInterface $command)
    {
        if (!$this->validator->validate($command)) {
            throw new FailCreateRootWithoutDevice($this->validator->getFirstErrorMessage());
        }

        try {
            /** @var RootParagraphWithoutDeviceInterface $paragraph */
            $paragraph = $this->paragraphMapper->map($command);
            $paragraph->setPosition($this->positionIterator->next($paragraph));

            $this->repository->create($paragraph);
        } catch (Exception $exception) {
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), 0, $exception);
        }
    }
}
