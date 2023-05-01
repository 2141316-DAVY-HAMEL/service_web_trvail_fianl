<?php

namespace App\Action\Poutine;

use App\Domain\Poutine\Service\PoutineUpdate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PoutineUpdateAction
{
    private $poutineUpdate;

    public function __construct(PoutineUpdate $poutineUpdate)
    {
        $this->poutineUpdate = $poutineUpdate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération des données du corps de la requête
        $data = (array)$request->getParsedBody();
        // Récupération du paramètre de route 'id'
        $id = $request->getAttribute('id', 0);


        $resultat = $this->poutineUpdate->updatePoutine($id, $data);

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat["poutine"]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($resultat["codeStatus"]);
    }
}
