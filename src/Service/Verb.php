<?php

namespace App\Service;

class Verb
{
    public function __construct(
        private readonly CsvManager $csvManager,
        private readonly array $fullyIrregularVerbs = ['dar', 'estar', 'haber', 'ir', 'ser']
    ) {

    }

    private function isIrregularVerb(string $verb, string $form, int $person): bool
    {
       $rootOfVerb = mb_substr($verb, 0, -2);
       $ending = mb_substr($form, mb_strlen($rootOfVerb));
       return in_array(mb_strtolower(trim($verb)), $this->fullyIrregularVerbs)
           || !str_starts_with($form, $rootOfVerb)
           || !$this->isValidRegularSpanishVerbForm($ending, $person);
    }
    function isValidRegularSpanishVerbForm(string $ending, int $person): bool
    {
        $ending = mb_strtolower(trim($ending), 'UTF-8');

        $endings = [
            0 => ['o'],         // yo (-ar, -er, -ir)
            1 => ['as', 'es'],       // tú
            2 => ['a', 'e'],         // él / ella / usted
            3 => ['amos', 'emos', 'imos'], // nosotros
            4 => ['áis', 'éis', 'ís'],     // vosotros
            5 => ['an', 'en']        // ellos / ellas / ustedes
        ];
        if (!isset($endings[$person])) {
            return false;
        }

        return in_array($ending, $endings[$person]);
    }
    public function getPresenteVerbs(): array
    {
        $dataRows = $this->csvManager->readCsv('/csv/verbs/presente.csv');
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

    private function prepareData(array $dataRow): array
    {
        $word = $dataRow[0] ?? '';
        $result = [
            'word' => $word,
            'translation' => $dataRow[1] ?? ''
        ];
        unset($dataRow[0], $dataRow[1]);
        $result['forms'] = $this->preparePresenteVerbs($word,$dataRow);
        return $result;
    }
    private function preparePresenteVerbs(string $word, array $items): array
    {
        $result = [];
        foreach ($items as $person => $item) {
            $result[] = [
                'word'=>$item,
                'isIrregular' => $this->isIrregularVerb($word, $item, $person - 2),
            ];
        }
        return $result;
    }


}
