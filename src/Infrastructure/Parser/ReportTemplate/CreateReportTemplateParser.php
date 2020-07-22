<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\CreateReportTemplateCommand;
use App\App\Command\ReportTemplate\CreateReportTemplateCommandInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Infrastructure\Exception\ReportTemplate\FailCreateReportTemplateAction;
use DateTime;
use Exception;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class CreateReportTemplateParser implements CreateReportTemplateParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateReportTemplateParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return CreateReportTemplateCommand
     * @throws Exception
     */
    public function parse(Request $request): CreateReportTemplateCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('createReportTemplateRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['createReportTemplateRequest'];

            if (!array_key_exists('id', $data)) {
                throw new InvalidArgumentException("ReportTemplate Id is required field");
            }

            if (!array_key_exists('serviceId', $data)) {
                throw new InvalidArgumentException("Service Id is required field");
            }

            if (!array_key_exists('deviceId', $data)) {
                throw new InvalidArgumentException("Device Id is required field");
            }

            $name = $data['name'] ?? null;

            if (!$name) {
                throw new InvalidArgumentException('Invalid Report Template Name');
            }

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var CreateReportTemplateCommandInterface $createReportTemplateCommand */
            $createReportTemplateCommand = new CreateReportTemplateCommand(
                new ReportTemplateId($data['id']),
                new DeviceId($data['deviceId']),
                new ServiceId($data['serviceId']),
                $name
            );
            $createReportTemplateCommand->setDescription($data['description'] ?? '');
            $createReportTemplateCommand->setCreatedAt(new DateTime());
            $createReportTemplateCommand->setCreatedBy($user);

            return $createReportTemplateCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailCreateReportTemplateAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailCreateReportTemplateAction("Bad request. " . $exception->getMessage());
        }
    }
}
