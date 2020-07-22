<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\CreateChildWithDeviceCommand;
use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\App\Repository\Paragraph\StyleTemplateQueryRepository;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\Paragraph\StyleTemplateQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\Paragraph\FailCreateAction;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class CreateChildWithDeviceParser implements CreateChildWithDeviceParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var StyleTemplateQueryRepositoryInterface */
    private $styleTemplateQueryRepository;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * CreateChildWithDeviceParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param StyleTemplateQueryRepositoryInterface $styleTemplateQueryRepository
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        StyleTemplateQueryRepositoryInterface $styleTemplateQueryRepository,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->styleTemplateQueryRepository = $styleTemplateQueryRepository;
        $this->headerFactory = $headerFactory;
    }

    /**
     * @param Request $request
     * @return CreateChildWithDeviceCommandInterface
     * @throws FailCreateAction
     */
    public function parse(Request $request): CreateChildWithDeviceCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('createParagraphRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['createParagraphRequest'];

            if (!array_key_exists('id', $data)) {
                throw new InvalidArgumentException("Paragraph Id is required field");
            }

            if (!array_key_exists('parentId', $data)) {
                throw new InvalidArgumentException("Parent Id is required field");
            }

            if (!array_key_exists('deviceId', $data)) {
                throw new InvalidArgumentException("Device Id is required field");
            }

            if (!array_key_exists('filterId', $data)) {
                throw new InvalidArgumentException("Filter Id is required field");
            }

            if (!array_key_exists('title', $data)) {
                throw new InvalidArgumentException("Title is required field");
            }

            if (!empty($data['title'])) {
                /** @var CustomHeaderInterface $header */
                $header = $this->headerFactory->makeCustom($data['title']);
            } else {
                /** @var DeviceCardHeaderInterface $header */
                $header = $this->headerFactory->makeDeviceCard();
            }

            /** @var BaseParagraphInterface $parentParagraph */
            $parentParagraph = $this->paragraphQueryRepository->find(new ParagraphId($data['parentId']));

            if (!$parentParagraph instanceof BaseParagraphInterface) {
                throw new InvalidParagraphIdException("Parent Paragraph was not found");
            }

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var CreateChildWithDeviceCommandInterface $createChildWithDeviceCommand */
            $createChildWithDeviceCommand = new CreateChildWithDeviceCommand(
                new ParagraphId($data['id']),
                new ParagraphId($data['parentId']),
                new DeviceId($data['deviceId']),
                new ParagraphFilterId($data['filterId']),
                $parentParagraph->getSectionId(),
                $header
            );

            if (array_key_exists('styleTemplateId', $data)) {
                $createChildWithDeviceCommand->setStyleTemplateId(new StyleTemplateId($data['styleTemplateId']));
            } else {
                /** @var StyleTemplateInterface $defaultStyleTemplate */
                $defaultStyleTemplate = $this->styleTemplateQueryRepository
                    ->find(new StyleTemplateId(StyleTemplateQueryRepository::DEFAULT_TEMPLATE));
                $createChildWithDeviceCommand->setStyleTemplateId($defaultStyleTemplate->getId());
            }

            $createChildWithDeviceCommand->setCreatedBy($user);
            $createChildWithDeviceCommand->setCreatedAt(new \DateTime());
            $createChildWithDeviceCommand->setPrintable(true);

            return $createChildWithDeviceCommand;
        } catch (InvalidArgumentException | InvalidParagraphIdException $exception) {
            throw new FailCreateAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailCreateAction("Bad request. " . $exception->getMessage());
        }
    }
}
