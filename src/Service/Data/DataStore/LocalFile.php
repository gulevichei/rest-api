<?php

namespace App\Service\Data\DataStore;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LocalFile implements DataStoreInterface
{
    /**
     * @var string
     */
    public $dataStoreDir;

    /**
     * @var string
     */
    public $dataProviderType;

    /**
     * FileManager constructor.
     *
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->dataStoreDir     = $parameterBag->get('dataProviderStoreDir');
        $this->dataProviderType = $parameterBag->get('dataProviderType');
    }

    /**
     * @param $fileName
     *
     * @return false|string
     * @throws Exception
     */
    public function getData($fileName)
    {
        $fileName = $fileName . '.' . $this->dataProviderType;
        if (!file_exists($this->dataStoreDir . $fileName)) {
            throw new Exception('File not found.');
        }

        return file_get_contents($this->dataStoreDir . $fileName);
    }

    /**
     * @param $data
     * @param $fileName
     *
     * @return false|int|mixed
     */
    public function saveData($data, $fileName)
    {
        $fileName = $fileName . '.' . $this->dataProviderType;
        if (!is_dir(dirname($this->dataStoreDir . $fileName))) {
            mkdir(dirname($this->dataStoreDir . $fileName), 0777, true);
        }
        return file_put_contents($this->dataStoreDir . $fileName, $data, 1);
    }
}
