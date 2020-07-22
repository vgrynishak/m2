<?php

namespace App\App\Mapper\Paragraph;

use App\App\Factory\Exception\FailMakeEntityHeaderModel;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\App\Doctrine\Entity\HeaderType as HeaderTypeEntity;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\Header\NoHeaderInterface;

class DoctrineEntityHeaderMapper implements DoctrineEntityHeaderMapperInterface
{
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * DoctrineEntityHeaderMapper constructor.
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(HeaderFactoryInterface $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    /**
     * @param HeaderTypeEntity $headerTypeEntity
     * @param string|null $value
     * @return BaseHeaderInterface
     * @throws FailMakeEntityHeaderModel
     */
    public function map(HeaderTypeEntity $headerTypeEntity, ?string $value): BaseHeaderInterface
    {
        if ($headerTypeEntity->getId() == CustomHeaderInterface::ID) {
            $header = $this->headerFactory->makeCustom($value);
        }

        if ($headerTypeEntity->getId() == DeviceCardHeaderInterface::ID) {
            $header = $this->headerFactory->makeDeviceCard();
        }

        if ($headerTypeEntity->getId() == NoHeaderInterface::ID) {
            $header = $this->headerFactory->makeNoHeader();
        }

        if (!$header instanceof BaseHeaderInterface) {
            throw new FailMakeEntityHeaderModel();
        }

        return $header;
    }
}
