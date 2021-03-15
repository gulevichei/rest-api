<?php

namespace App\Service\Data\DataStore;

/**
 * Interface DataProviderTypeInterface
 *
 * @package App\Service\Data\DataProviderType
 */
interface DataStoreInterface
{
    /**
     * @param $fileName
     *
     * @return mixed
     */
    public function getData($fileName);

    /**
     * @param $data
     * @param $fileName
     *
     * @return mixed
     */
    public function saveData($data, $fileName);
}
