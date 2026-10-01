<?php

namespace App\Service;

class PresenteVerbs extends Verb
{
    protected function getFullyIrregularVerbs(): array
    {
        return ['dar', 'estar', 'haber', 'ir', 'ser'];
    }

    protected function isValidRegularSpanishVerbForm(string $ending, int $person): bool
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

    protected function getPath(): string
    {
        return '/csv/verbs/presente.csv';
    }

}
