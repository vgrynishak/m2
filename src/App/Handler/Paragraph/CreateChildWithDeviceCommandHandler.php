<?php

namespace App\App\Handler\Paragraph;

use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\App\Command\Paragraph\Mapper\ParagraphMapperByCommandInterface;
use App\App\Command\Paragraph\Validator\CreateChildWithDeviceValidatorInterface;
use App\Core\Model\Paragraph\ChildParagraphWithDeviceInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Service\Paragraph\LevelIteratorInterface;
use App\Infrastructure\Exception\Paragraph\FailCreateAction;
use App\Core\Service\Paragraph\PositionIteratorInterface;

class CreateChildWithDeviceCommandHandler
{
    /** @var CreateChildWithDeviceValidatorInterface */
    private $createChildWithDeviceValidator;

    /** @var ParagraphMapperByCommandInterface */
    private $paragraphMapper;

    /** @var PositionIteratorInterface */
    private $positionIterator;

    /** @var LevelIteratorInterface */
    private $levelIterator;

    /** @var ParagraphCommandRepositoryInterface */
    private $paragraphRepository;

    /**
     * CreateChildWithDeviceCommandHandler constructor.
     * @param CreateChildWithDeviceValidatorInterface $createChildWithDeviceValidator
     * @param PositionIteratorInterface $positionIterator
     * @param LevelIteratorInterface $levelIterator
     * @param ParagraphMapperByCommandInterface $paragraphMapper
     */
    public function __construct(
        CreateChildWithDeviceValidatorInterface $createChildWithDeviceValidator,
        PositionIteratorInterface $positionIterator,
        LevelIteratorInterface $levelIterator,
        ParagraphMapperByCommandInterface $paragraphMapper,
        ParagraphCommandRepositoryInterface $paragraphRepository
    ) {
        $this->createChildWithDeviceValidator = $createChildWithDeviceValidator;
        $this->positionIterator = $positionIterator;
        $this->levelIterator = $levelIterator;
        $this->paragraphMapper = $paragraphMapper;
        $this->paragraphRepository = $paragraphRepository;
    }

    /**
     * @param CreateChildWithDeviceCommandInterface $command
     * @throws FailCreateAction
     */
    public function __invoke(CreateChildWithDeviceCommandInterface $command)
    {
        if (!$this->createChildWithDeviceValidator->validate($command)) {
            throw new FailCreateAction($this->createChildWithDeviceValidator->getFirstErrorMessage());
        }

        try {
            /** @var ChildParagraphWithDeviceInterface $paragraph */
            $paragraph = $this->paragraphMapper->map($command);
            $paragraph->setPosition($this->positionIterator->next($paragraph));
            $paragraph->setLevel($this->levelIterator->next($paragraph));

            $this->paragraphRepository->create($paragraph);
        } catch (\Exception $exception) {
            throw new FailCreateAction($exception->getMessage());
        }
    }
}
