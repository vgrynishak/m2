<?php

namespace App\Infrastructure\Adapter\InfoSource;

use App\Core\Model\Item\InformationItem\InfoSource\InfoSource;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Adapter\DTO\DeviceDynamicField\Full as FullInfoSourceDTO;

class Full
{
    /**
     * @param CollectionInterface|null $dynamicFields
     * @return array
     */
    public static function adaptList(?CollectionInterface $dynamicFields): array
    {
        /** @var array $result */
        $result = [];

        if ($dynamicFields instanceof CollectionInterface) {
            /** @var InfoSource $infoSource */
            foreach ($dynamicFields as $infoSource) {
                $result['resultDeviceDynamicFields'][] = new FullInfoSourceDTO(
                    $infoSource->getId()->getValue(),
                    $infoSource->getDictionary()->getValue(),
                    $infoSource->getName()
                );
            }
        }

        return $result;
    }
}
