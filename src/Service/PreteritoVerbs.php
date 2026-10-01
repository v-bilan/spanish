<?php

namespace App\Service;

class PreteritoVerbs extends Verb
{
    protected function getFullyIrregularVerbs(): array
    {
        return ['dar', 'ir', 'ser'];
    }

    protected function isValidRegularSpanishVerbForm(string $ending, int $person): bool
    {
        $ending = mb_strtolower(trim($ending), 'UTF-8');

        $endings = [
            0 => ['e', 'í', 'i','í'],         // yo (-ar, -er, -ir)
            1 => ['aste', 'iste', 'íste'],       // tú
            2 => ['o', 'io', 'ó', 'ió'],         // él / ella / usted
            3 => ['amos', 'imos', 'ímos'], // nosotros
            4 => ['ásteis', 'ísteis', 'isteis', 'asteis'],     // vosotros
            5 => ['aron', 'ieron']        // ellos / ellas / ustedes
        ];
        if (!isset($endings[$person])) {
            return false;
        }

        return in_array($ending, $endings[$person]);
    }

    protected function getPath(): string
    {
        return '/csv/verbs/preterito.csv';
    }
}
