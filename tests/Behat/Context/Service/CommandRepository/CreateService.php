<?php

namespace App\Tests\Behat\Context\Service\CommandRepository;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\Facility;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\Service;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;
use App\Core\Repository\Service\ServiceCommandRepositoryInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class CreateService implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var ServiceCommandRepositoryInterface */
    private $serviceCommandRepository;

    /** @var ServiceInterface */
    private $service;

    /** @var Connection */
    private $doctrineConnection;

    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;

    /** @var FacilityQueryRepositoryInterface */
    private $facilityQueryRepository;

    /** @var ServiceInterface */
    private $result;

    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateService constructor.
     * @param ServiceCommandRepositoryInterface $serviceCommandRepository
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param Connection $connection
     * @param FacilityQueryRepositoryInterface $facilityQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ServiceCommandRepositoryInterface $serviceCommandRepository,
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        Connection $connection,
        FacilityQueryRepositoryInterface $facilityQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->serviceCommandRepository = $serviceCommandRepository;
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->doctrineConnection = $connection;
        $this->facilityQueryRepository = $facilityQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @Given I'm Set correct Service model
     */
    public function imSetCorrectServiceModel()
    {
        /** @var FacilityId $facilityId */
        $facilityId = new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9');
        /** @var Facility $facility */
        $facility = $this->facilityQueryRepository->find($facilityId);
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->service = new Service(
            new ServiceId('e6bdaad4-d61c-4c8e-b6f8-c8aec9aa66de'),
            new DeviceId('0456cf66-177f-4186-8978-d332102b31ff'),
            $facility,
            'New test Service 2'
        );

        $this->service->setComment('New test comment 2');
        $this->service->setCreatedAt(new DateTime());
        $this->service->setUpdatedAt(new DateTime());
        $this->service->setCreatedBy($user);
        $this->service->setModifiedBy($user);
    }

    /**
     * @When I Call Method Create
     * @throws ConnectionException
     */
    public function iCallMethodCreate()
    {
        $this->doctrineConnection->beginTransaction();
        $this->serviceCommandRepository->create($this->service);
        $this->result = $this->serviceQueryRepository->find($this->service->getId());
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should get created service
     */
    public function iShouldGetCreatedService()
    {
        Assert::assertTrue($this->result instanceof ServiceInterface);
    }
}
