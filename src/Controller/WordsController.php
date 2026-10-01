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
        $wordsData = $words->getWords();

        return $this->render('words/list.html.twig', [
            'wordsData' => $wordsData,
        ]);
    }
}
