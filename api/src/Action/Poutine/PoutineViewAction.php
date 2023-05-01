<?php

namespace App\Action\Poutine;

use App\Domain\Poutine\Service\PoutineView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PoutineViewAction
{
    private $poutineView;

    public function __construct(PoutineView $poutineView)
    {
        $this->poutineView = $poutineView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // S'il n'y a pas de paramètre, retourne un tableau vide
        $queryParams = $request->getQueryParams() ?? [];

        $resultat = $this->poutineView->viewAllPoutines($queryParams);

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
