<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\CreateRootWithoutDeviceCommand;
use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\App\Repository\Paragraph\StyleTemplateQueryRepository;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\NoHeaderInterface;
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

class CreateRootWithoutDeviceParser implements CreateRootWithoutDeviceParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var StyleTemplateQueryRepositoryInterface */
    private $styleTemplateQueryRepository;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * CreateRootWithoutDeviceParser constructor.
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
     * @return CreateRootWithoutDeviceCommandInterface
     * @throws FailCreateAction
     */
    public function parse(Request $request): CreateRootWithoutDeviceCommandInterface
    {
        try {
            /** @var array $body */
            $body = $request->request->all();
            if (!array_key_exists('createParagraphRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }
            /** @var array $data */
            $data = $body['createParagraphRequest'];

            if (!array_key_exists('id', $data)) {
                throw new InvalidArgumentException("Paragraph Id is required field");
            }

            if (!array_key_exists('sectionId', $data)) {
                throw new InvalidArgumentException("Section Id is required field");
            }

            if (!array_key_exists('title', $data)) {
                throw new InvalidArgumentException("Title is required field");
            }

            if (!empty($data['title'])) {
                /** @var CustomHeaderInterface $header */
                $header = $this->headerFactory->makeCustom($data['title']);
            } else {
                /** @var NoHeaderInterface $header */
                $header = $this->headerFactory->makeNoHeader();
            }

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var ParagraphId $paragraphId */
            $paragraphId = new ParagraphId($data['id']);
            /** @var SectionId $sectionId */
            $sectionId = new SectionId($data['sectionId']);

            /** @var CreateRootWithoutDeviceCommandInterface $createParagraphCommand */
            $createParagraphCommand = new CreateRootWithoutDeviceCommand(
                $paragraphId,
                $sectionId,
                true,
                $header
            );

            if (array_key_exists('styleTemplateId', $data)) {
                $createParagraphCommand->setStyleTemplateId(new StyleTemplateId($data['styleTemplateId']));
            } else {
                /** @var StyleTemplateInterface $defaultStyleTemplate */
                $defaultStyleTemplate = $this->styleTemplateQueryRepository
                    ->find(new StyleTemplateId(StyleTemplateQueryRepository::DEFAULT_TEMPLATE));
                $createParagraphCommand->setStyleTemplateId($defaultStyleTemplate->getId());
            }

            $createParagraphCommand->setCreatedBy($user);
            $createParagraphCommand->setCreatedAt(new \DateTime());

            return $createParagraphCommand;

        } catch (InvalidArgumentException $exception) {
            throw new FailCreateAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailCreateAction("Bad request. " . $exception->getMessage());
        }
    }
}
