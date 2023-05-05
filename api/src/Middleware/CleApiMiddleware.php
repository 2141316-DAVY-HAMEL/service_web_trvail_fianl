<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\ModelUsager\Usager;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class CleApiMiddleware
{
	private $usager;

	public function __construct(Usager $usager)
	{
		$this->usager = $usager;
	}

	public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
	{

		$apiKey = explode(' ', $request->getHeaderLine('Authorization'))[1] ?? '';


		$user = $this->usager->getUserByApiKey($apiKey);


		if (!$user) {

			return $this->unauthorizedResponse($apiKey);
		}


		$response = $handler->handle($request);
		return $response;
	}


	private function unauthorizedResponse($test): Response
	{
		$response = new Response(403);
		$response->getBody()->write(json_encode([
			'erreur' => 'La clé est invalide. Accès non autorisé'. $test
		]));

		return $response;
	}
}

