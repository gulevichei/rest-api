<?php

namespace App\Service\Data;

use Exception;
use Psr\Log\LoggerInterface;

class DataProvider
{
    /** @var DataConvertor\CSV|DataConvertor\JSON */
    private $dataProviderService;

    /** @var DataStore\LocalFile */
    private $dataStoreConfiguration;

    /** @var LoggerInterface */
    private $logger;

    /**
     * DataProvider constructor.
     *
     * @param LoggerInterface            $logger
     * @param DataConvertorConfiguration $dataProviderConfiguration
     * @param DataStoreConfiguration     $dataStoreConfiguration
     */
    public function __construct(
        LoggerInterface $logger,
        DataConvertorConfiguration $dataProviderConfiguration,
        DataStoreConfiguration $dataStoreConfiguration
    ) {
        $this->logger                 = $logger;
        $this->dataProviderService    = $dataProviderConfiguration->getDataProviderService();
        $this->dataStoreConfiguration = $dataStoreConfiguration->getDataStoreService();
    }

    /**
     * @param string $fileName
     *
     * @return false|mixed|string
     */
    public function getListOf($fileName = '')
    {
        $data = [];
        try {
            $data = $this->dataStoreConfiguration->getData($fileName);
            $data = $this->dataProviderService->toObject($data);
        } catch (Exception $exception) {
            $this->logger->error(
                'Data Store Error: ' . $exception->getMessage(),
                $exception->getTrace()
            );
        }

        return $data;
    }

    /**
     * @param        $fileData
     * @param string $fileName
     *
     * @return bool
     */
    public function save($fileData, $fileName = '')
    {
        try {
            $fileData = $this->dataProviderService->toString($fileData);
            $this->dataStoreConfiguration->saveData($fileData, $fileName);
        } catch (Exception $exception) {
            $this->logger->error(
                'Data Store Error: ' . $exception->getMessage(),
                $exception->getTrace()
            );
            return false;
        }
        return true;
    }

}
