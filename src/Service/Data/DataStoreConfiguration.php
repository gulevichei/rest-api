<?php

namespace App\Service\Data;

use App\Service\Data\DataStore\LocalFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class DataProviderConfiguration
 *
 * @package App\Service\Data
 */
class DataStoreConfiguration
{
    /**
     * @var ParameterBagInterface
     */
    protected $parameterBag;

    /**
     * FileTransferConfiguration constructor.
     *
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @return LocalFile
     */
    public function getDataStoreService()
    {
        $fileTransfer = $this->parameterBag->get('dataProviderStore');
        switch ($fileTransfer) {
            case 'local':
            default:
                return new LocalFile($this->parameterBag);
                break;
        }
    }
}
