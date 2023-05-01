<?php

namespace App\Action\Poutine;

use App\Domain\Poutine\Service\PoutineCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PoutineCreateAction
{
    private $poutineCreate;

    public function __construct(PoutineCreate $poutineCreate)
    {
        $this->poutineCreate = $poutineCreate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération des données du corps de la requête
        $data = (array)$request->getParsedBody();

        $resultat = $this->poutineCreate->addPoutine($data);

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
