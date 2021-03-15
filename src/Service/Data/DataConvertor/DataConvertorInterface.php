<?php

namespace App\Service\Data\DataConvertor;

/**
 * Interface DataProviderTypeInterface
 *
 * @package App\Service\Data\DataProviderType
 */
interface DataConvertorInterface
{
    /**
     * @param $content
     *
     * @return mixed
     */
    public function toObject($content);

    /**
     * @param $object
     *
     * @return mixed
     */
    public function toString($object);
}
