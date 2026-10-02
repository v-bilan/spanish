<?php

namespace App\Service;

class Words
{
    public function __construct(
        private readonly CsvManager $csvManager
    ) {}

    public function getWords(string $path='/csv/words.csv'): array
    {
        $dataRows = $this->csvManager->readCsv($path);

        $items = [];
        $key = null;
        foreach ($dataRows as $dataRow) {
            if (!($dataRow[0] ?? null)) {
                continue;
            }

            if (!($dataRow[1] ?? null)) {
                $key = trim($dataRow[0]);
                continue;
            }
            $items[$key][] = $dataRow;
        }
        return $items;
    }
}
