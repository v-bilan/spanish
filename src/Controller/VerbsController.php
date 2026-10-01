<?php

namespace App\Controller;

use App\Service\Verb;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VerbsController extends AbstractController
{
    #[Route('/verbs/presente/list', name: 'app_verbs_presente_list')]
    public function index(Verb $verb): Response
    {
        $verbs = $verb->getPresenteVerbs();

        return $this->render('verbs/presente/list.html.twig', [
            'verbs' => $verbs,
        ]);
    }
}
