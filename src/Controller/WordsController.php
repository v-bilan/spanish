<?php

namespace App\Controller;

use App\Service\Words;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WordsController extends AbstractController
{
    #[Route('/words', name: 'app_words_list')]
    public function words(Words $words): Response
    {
        $wordsData = $words->getWords('/csv/words.csv');

        return $this->render('/words/list.html.twig', [
            'wordsData' => $wordsData,
        ]);
    }

    #[Route('/preposicionesYConjunciones', name: 'app_words_preposiciones')]
    public function preposicionesyConjunciones(Words $words): Response
    {
        $wordsData = $words->getWords('/csv/preposiciones_y_conjunciones.csv');

        return $this->render('/words/list.html.twig', [
            'wordsData' => $wordsData,
        ]);
    }

    #[Route('/infinitivo', name: 'app_infinitivo')]
    public function infinitivo(Words $words): Response
    {
        $wordsData = $words->getWords('/csv/verbs/infinitivo.csv');

        return $this->render('/words/list.html.twig', [
            'wordsData' => $wordsData,
        ]);
    }

    #[Route('/verbos_con_preposiciones', name: 'app_verbos_con_preposiciones')]
    public function verbos_con_preposiciones(Words $words): Response
    {
        $wordsData = $words->getWords('/csv/verbs/verbos_con_preposiciones.csv');

        return $this->render('/words/list.html.twig', [
            'wordsData' => $wordsData,
        ]);
    }
}
