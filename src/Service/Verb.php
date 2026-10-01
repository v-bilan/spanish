<?php

namespace App\Service;

abstract class Verb
{
    public function __construct(
        private readonly CsvManager $csvManager
    ) {}


    protected abstract function getFullyIrregularVerbs(): array;


    private function isIrregularForm(string $verb, string $form, int $person): bool
    {
       $rootOfVerb = mb_substr($verb, 0, -2);
       $ending = mb_substr($form, mb_strlen($rootOfVerb));
       return in_array(mb_strtolower(trim($verb)), $this->getFullyIrregularVerbs())
           || !str_starts_with($form, $rootOfVerb)
           || !$this->isValidRegularSpanishVerbForm($ending, $person);
    }
    protected abstract function isValidRegularSpanishVerbForm(string $ending, int $person): bool;

    public function getVerbs(): array
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
            $items[$key][] = $this->prepareData($dataRow);
        }
        return $items;
    }

    abstract protected function getPath(): string;
    private function prepareData(array $dataRow): array
    {
        $word = $dataRow[0] ?? '';
        $result = [
            'word' => $word,
            'transl' => $dataRow[1] ?? ''
        ];
        unset($dataRow[0], $dataRow[1]);
        $result['forms'] = $this->prepareVerbs($word,$dataRow);

        return $result;
    }
    private function prepareVerbs(string $word, array $items): array
    {
        $result = [];
        foreach ($items as $person => $item) {
            $result[] = [
                'word'=>$item,
                'isIrregular' => $this->isIrregularForm($word, $item, $person - 2),
            ];
        }
        return $result;
    }

}
