<?php

namespace App\Service\Translate;

use Exception;
use Psr\Log\LoggerInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslateService
{
    /** @var LoggerInterface */
    public $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param        $content
     * @param string $from
     * @param string $to
     *
     * @return mixed
     */
    public function translate($content, $from = 'en', $to = 'ru')
    {
        $tr = new GoogleTranslate();
        try {
            return $tr->setSource($from)->setTarget($to)->translate($content);
        } catch (Exception $exception) {
            $this->logger->error(
                'GoogleTranslate Exception: ' . $exception->getMessage(),
                $exception->getTrace()
            );
        }
        return $content;
    }
}
