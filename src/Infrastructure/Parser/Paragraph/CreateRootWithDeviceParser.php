<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\CreateRootWithDeviceCommand;
use App\App\Command\Paragraph\CreateRootWithDeviceCommandInterface;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\App\Repository\Paragraph\StyleTemplateQueryRepository;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Paragraph\StyleTemplateQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\Paragraph\FailCreateAction;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class CreateRootWithDeviceParser implements CreateRootWithDeviceParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var StyleTemplateQueryRepositoryInterface */
    private $styleTemplateQueryRepository;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * CreateRootWithDeviceParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param StyleTemplateQueryRepositoryInterface $styleTemplateQueryRepository
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        StyleTemplateQueryRepositoryInterface $styleTemplateQueryRepository,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->styleTemplateQueryRepository = $styleTemplateQueryRepository;
        $this->headerFactory = $headerFactory;
    }

    /**
     * @param Request $request
     * @return CreateRootWithDeviceCommand
     * @throws FailCreateAction
     */
    public function parse(Request $request): CreateRootWithDeviceCommandInterface
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

            if (!array_key_exists('sectionId', $data)) {
                throw new InvalidArgumentException("Section Id is required field");
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

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            $createRootWithDeviceCommand = new CreateRootWithDeviceCommand(
                new ParagraphId($data['id']),
                new SectionId($data['sectionId']),
                new DeviceId($data['deviceId']),
                new ParagraphFilterId($data['filterId']),
                $header
            );

            if (array_key_exists('styleTemplateId', $data)) {
                $createRootWithDeviceCommand->setStyleTemplateId(new StyleTemplateId($data['styleTemplateId']));
            } else {
                /** @var StyleTemplateInterface $defaultStyleTemplate */
                $defaultStyleTemplate = $this->styleTemplateQueryRepository
                    ->find(new StyleTemplateId(StyleTemplateQueryRepository::DEFAULT_TEMPLATE));
                $createRootWithDeviceCommand->setStyleTemplateId($defaultStyleTemplate->getId());
            }

            $createRootWithDeviceCommand->setCreatedBy($user);
            $createRootWithDeviceCommand->setCreatedAt(new \DateTime());
            $createRootWithDeviceCommand->setPrintable(true);

            return $createRootWithDeviceCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailCreateAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailCreateAction("Bad request. " . $exception->getMessage());
        }
    }
}
