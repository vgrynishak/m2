<?php

namespace App\Tests\Behat\Context\Device;

use App\App\Command\Device\CreateDeviceCommand;
use App\App\Handler\Device\CreateDeviceHandler;
use App\APP\Doctrine\Entity\Device;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Exception;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Division\DivisionId;

class CreateCommand implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var Connection */
    private $doctrineConnection;
    /** @var CreateDeviceHandler */
    private $createDeviceCommandHandler;
    /** @var Device */
    private $device;
    /** @var CreateDeviceCommand */
    private $createDeviceCommand;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateCommand constructor.
     * @param CreateDeviceHandler $createDeviceCommandHandler
     * @param Connection $connection
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        CreateDeviceHandler $createDeviceCommandHandler,
        Connection $connection,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->createDeviceCommandHandler = $createDeviceCommandHandler;
        $this->doctrineConnection = $connection;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param $id
     * @param $name
     * @param $parentId
     * @param $alias
     * @throws InvalidDeviceIdException
     * @throws InvalidDivisionIdException
     *
     * @Given Device param id :arg1 name :arg2 and parentId :arg3 and alias :arg4
     */
    public function deviceParamNameAndParentid($id, $name, $parentId, $alias)
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->createDeviceCommand = new CreateDeviceCommand(
            new DeviceId($id),
            $name,
            new DivisionId("37032816-e587-44cd-9a46-50819f2996b9"),
            1,
            $alias,
            $user
        );
        $this->createDeviceCommand->setParentId(new DeviceId($parentId));
        $this->createDeviceCommand->setDescription("test");
    }

    /**
     * @When I call create device command handler
     *
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws Exception
     */
    public function iCallCreateDeviceCommandHandler()
    {
        /** @var CreateDeviceHandler $handler */
        $handler = $this->createDeviceCommandHandler;

        $this->doctrineConnection->beginTransaction();
        $this->device = $handler($this->createDeviceCommand);
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should have created Device entity
     *
     * @return bool
     */
    public function iShouldHaveCreatedDeviceEntity()
    {
        if (!$this->device instanceof Device) {
            return false;
        }

        return true;
    }
}
