<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\ChangeParagraphPositionCommand;
use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\Paragraph\FailChangeParagraphPositionAction;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use Exception;

class ChangeParagraphPositionParser implements ChangeParagraphPositionParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * ChangeParagraphPositionParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return ChangeParagraphPositionCommandInterface
     * @throws FailChangeParagraphPositionAction
     */
    public function parse(Request $request): ChangeParagraphPositionCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('changeParagraphPositionRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['changeParagraphPositionRequest'];

            if (!array_key_exists('id', $data)) {
                throw new InvalidArgumentException("Paragraph Id is required field");
            }

            if (!array_key_exists('newPosition', $data)) {
                throw new InvalidArgumentException("newPosition is required field");
            }

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var ChangeParagraphPositionCommandInterface $changeParagraphPositionCommand */
            $changeParagraphPositionCommand = new ChangeParagraphPositionCommand(
                new ParagraphId($data['id']),
                $data['newPosition'],
                $user
            );

            return $changeParagraphPositionCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailChangeParagraphPositionAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailChangeParagraphPositionAction("Bad request. " . $exception->getMessage());
        }
    }
}
