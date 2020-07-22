<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\DeleteParagraphCommand;
use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\Paragraph\FailDeleteParagraphAction;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use Exception;

class DeleteParagraphParser implements DeleteParagraphParserInterface
{
    /** @var UserQueryRepositoryInterface  */
    private $userQueryRepository;

    /**
     * DeleteSectionParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return DeleteParagraphCommandInterface
     * @throws FailDeleteParagraphAction
     */
    public function parse(Request $request): DeleteParagraphCommandInterface
    {
        try {
            /** @var ParagraphId $paragraphId */
            $paragraphId = $request->get('paragraphId');
            if (!$paragraphId instanceof ParagraphId) {
                throw new InvalidArgumentException('Paragraph Id is required field');
            }
            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var DeleteParagraphCommandInterface $deleteParagraphCommand */
            $deleteParagraphCommand = new DeleteParagraphCommand($paragraphId, $user);

            return $deleteParagraphCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailDeleteParagraphAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailDeleteParagraphAction("Bad request. " . $exception->getMessage());
        }
    }
}
