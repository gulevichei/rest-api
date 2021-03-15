<?php

namespace App\Service\Data\DataConvertor;

class JSON implements DataConvertorInterface
{

    /**
     * @param $content
     *
     * @return mixed
     */
    public function toObject($content)
    {
        return json_decode($content);
    }

    /**
     * @param $object
     *
     * @return false|mixed|string
     */
    public function toString($object)
    {
        return json_encode($object);
    }
}
