<?php

namespace App\Service\Data;

use App\Service\Data\DataConvertor\CSV;
use App\Service\Data\DataConvertor\JSON;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class DataProviderConfiguration
 *
 * @package App\Service\Data
 */
class DataConvertorConfiguration
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
     * @return CSV|JSON
     */
    public function getDataProviderService()
    {
        $fileTransfer = $this->parameterBag->get('dataProviderType');
        switch ($fileTransfer) {
            case 'json':
                return new JSON();
                break;
            case 'csv':
            default:
                return new CSV();
                break;
        }
    }
}
