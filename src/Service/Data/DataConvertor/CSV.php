<?php

namespace App\Service\Data\DataConvertor;

use stdClass;

/**
 * Class CSV
 *
 * @package App\Service\Data\DataConvertor
 */
class CSV implements DataConvertorInterface
{

    /**
     * @param $content
     *
     * @return array
     */
    public function toObject($content)
    {
        $lines = explode("\n", $content);
        $list  = [];
        foreach ($lines as $key => $line) {
            if ($key == 0 || empty($line)) {
                continue;
            }
            $data              = str_getcsv($line);
            $object            = new stdClass();
            $object->text      = $data[0];
            $object->createdAt = $data[1];
            $object->choices   = [
                $this->newChoice($data[2]),
                $this->newChoice($data[3]),
                $this->newChoice($data[4]),
            ];
            $list[]            = $object;
        }

        return $list;
    }

    /**
     * @param $choiceText
     *
     * @return stdClass
     */
    private function newChoice($choiceText): stdClass
    {
        $choice       = new stdClass();
        $choice->text = $choiceText;
        return $choice;
    }

    /**
     * @param $object
     *
     * @return mixed
     */
    public function toString($object)
    {
        $csvData   = [];
        $csvData[] = '"' . implode(
                [
                    "Question text",
                    "Created At",
                    "Choice 1",
                    "Choice",
                    "Choice 3",
                ],
                '", "'
            ) . '"';

        foreach ($object as $item) {
            $csvData[] = '"' . implode(
                    [
                        $item->text,
                        $item->createdAt,
                        $item->choices[0]->text,
                        $item->choices[1]->text,
                        $item->choices[2]->text,
                    ],
                    '", "'
                ) . '"';
        }

        return implode($csvData, "\n");
    }
}
