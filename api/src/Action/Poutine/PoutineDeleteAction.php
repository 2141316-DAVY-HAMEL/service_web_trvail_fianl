<?php

namespace App\Action\Poutine;

use App\Domain\Poutine\Service\PoutineDelete;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PoutineDeleteAction
{
    private $poutineDelete;

    public function __construct(PoutineDelete $poutineDelete)
    {
        $this->poutineDelete = $poutineDelete;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération du paramètre de route 'id'
        $id = $request->getAttribute('id', 0);

        $resultat = $this->poutineDelete->removepoutine($id);

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat["poutine"]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($resultat["codeStatus"]);
    }
}
