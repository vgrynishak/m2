<?php

namespace App\App\Handler\Paragraph;

use App\App\Command\Paragraph\CreateRootWithDeviceCommand;
use App\App\Command\Paragraph\Validator\CreateRootWithDeviceValidatorInterface;
use App\App\Command\Paragraph\Mapper\ParagraphMapperByCommandInterface;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Service\Paragraph\PositionIteratorInterface;
use App\Infrastructure\Exception\Paragraph\FailCreateAction;

class CreateRootWithDeviceCommandHandler
{
    /** @var CreateRootWithDeviceValidatorInterface */
    private $createRootWithDeviceValidator;

    /** @var ParagraphMapperByCommandInterface */
    private $paragraphMapper;

    /** @var ParagraphCommandRepositoryInterface */
    private $paragraphRepository;

    /** @var PositionIteratorInterface */
    private $positionIterator;

    public function __construct(
        CreateRootWithDeviceValidatorInterface $createRootWithDeviceValidator,
        ParagraphMapperByCommandInterface $paragraphMapper,
        ParagraphCommandRepositoryInterface $paragraphRepository,
        PositionIteratorInterface $positionIterator
    ) {
        $this->createRootWithDeviceValidator = $createRootWithDeviceValidator;
        $this->paragraphMapper = $paragraphMapper;
        $this->paragraphRepository = $paragraphRepository;
        $this->positionIterator = $positionIterator;
    }

    /**
     * @param CreateRootWithDeviceCommand $command
     *
     * @throws FailCreateAction
     * @throws \Exception
     */
    public function __invoke(CreateRootWithDeviceCommand $command)
    {
        if (!$this->createRootWithDeviceValidator->validate($command)) {
            throw new FailCreateAction($this->createRootWithDeviceValidator->getFirstErrorMessage());
        }

        try {
            /** @var RootParagraphWithDeviceInterface $paragraph */
            $paragraph = $this->paragraphMapper->map($command);
            $paragraph->setPosition($this->positionIterator->next($paragraph));

            $this->paragraphRepository->create($paragraph);
        } catch (\Exception $exception) {
            throw new FailCreateAction($exception->getMessage());
        }
    }
}
