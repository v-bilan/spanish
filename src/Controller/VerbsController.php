<?php

namespace App\Controller;

use App\Service\PresenteVerbs;
use App\Service\PreteritoVerbs;
use App\Service\Verb;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VerbsController extends AbstractController
{
    private function getList(Verb $verbsManager, string $type): Response
    {
        return $this->render('verbs/list.html.twig', [
            'verbs' => $verbsManager->getVerbs(),
            'type' => $type,
        ]);
    }
    #[Route('/verbs/presente/list', name: 'app_verbs_presente_list')]
    public function presenteList(PresenteVerbs $verbsManager): Response
    {
        return $this->getList($verbsManager, 'Presente Indefinido' );
    }


    #[Route('/verbs/preterito/list', name: 'app_verbs_preterito_list')]
    public function preteritoList(PreteritoVerbs $verbsManager): Response
    {
        return $this->getList($verbsManager, 'Preterito Indefinido');
    }
}
