<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\ModelUsager\Usager;


class CleApiAction
{
	private $usager;

	public function __construct(Usager $usager)
	{
		$this->usager = $usager;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{

		$headersApi = $request->getHeaderLine('Authorization') ?? '';


		$headersApi = base64_decode($headersApi);


		list($username, $password) = explode(':', $headersApi);


		$user = $this->usager->verifyUser($username, $password);


		if (!$user) {

			$response->getBody()->write(json_encode(['erreur' => 'Non autorisé']));
			return $response->withStatus(403);
		}


		$nouvelleCle = isset($request->getQueryParams()['nouvelle']) && $request->getQueryParams()['nouvelle'] == 'true';


		if (!$user['cle_api'] || $nouvelleCle) {

			$cleApi = $this->usager->generateApiKey();

			$this->usager->updateApiKey((int)$user['id'], $cleApi);
		} else {

			$cleApi = $user['cle_api'];
		}


		$response->getBody()->write(json_encode(['cle_api' => $cleApi]));
		return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
	}
}

