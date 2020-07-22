<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\EditParagraphCommand;
use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\Paragraph\FailEditAction;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class EditParagraphParser implements EditParagraphParserInterface
{
    /** @var UserQueryRepositoryInterface  */
    private $userQueryRepository;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * EditParagraphParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->headerFactory = $headerFactory;
    }

    /**
     * @param Request $request
     * @return EditParagraphCommandInterface
     * @throws FailEditAction
     */
    public function parse(Request $request): EditParagraphCommandInterface
    {
        try {
            /** @var array $body */
            $body = $request->request->all();
            if (!array_key_exists('editParagraphRequest', $body)) {
                throw new InvalidArgumentException('Invalid Root key');
            }
            /** @var array $data */
            $data = $body['editParagraphRequest'];

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

            /** @var ParagraphId $paragraphId */
            $paragraphId = $request->get('paragraphId');
            if (!$paragraphId instanceof ParagraphId) {
                throw new InvalidArgumentException('Paragraph Id is required field');
            }

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var EditParagraphCommandInterface $editParagraphCommand */
            $editParagraphCommand = new EditParagraphCommand(
                $paragraphId,
                $header,
                $user
            );

            return $editParagraphCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailEditAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailEditAction("Bad request. " . $exception->getMessage());
        }
    }
}
