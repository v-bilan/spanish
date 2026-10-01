<?php

namespace App\Service;

class Words
{
    public function __construct(
        private readonly CsvManager $csvManager
    ) {}

    public function getWords(): array
    {
        $dataRows = $this->csvManager->readCsv($this->getPath());

        $items = [];
        $key = null;
        foreach ($dataRows as $dataRow) {
            if (!($dataRow[0] ?? null)) {
                continue;
            }
            if (empty($dataRow[1] ?? null)) {
                $key = trim($dataRow[0]);
                continue;
            }
            $items[$key][] = $dataRow;
        }
        return $items;
    }

    protected function getPath(): string
    {
        return '/csv/words.csv';
    }

}
