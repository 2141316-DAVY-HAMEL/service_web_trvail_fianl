<?php

namespace App\ModelUsager;

use PDO;

class Usager
{
	private $connection;

	public function __construct(PDO $connection)
	{
		$this->connection = $connection;
	}

	// Méthode pour vérifier Si l'usager et/ou le mot de passe est invalide
	public function verifyUser(string $codeUsager, string $motDePasse): ?array
	{
		$sql = "SELECT * FROM usager WHERE code = :codeusager";
		$query = $this->connection->prepare($sql);
		$query->execute(['codeusager' => $codeUsager]);

		$result = $query->fetch(PDO::FETCH_ASSOC);


		if ($result && password_verify($motDePasse, $result['password'])) {
			return $result;
		}
		else {
			return null;
		}
	}

	// Méthode qui génère une clé API unique
	public function generateApiKey(): string
	{
		return bin2hex(random_bytes(10));
	}

	// Méthode pour mettre à jour la clé API de l'utilisateur
	public function updateApiKey(int $userId, string $apiKey): void
	{
		$sql = "UPDATE usager SET api_key = :cle_api WHERE id = :id";
		$query = $this->connection->prepare($sql);
		$query->execute(['cle_api' => $apiKey, 'id' => $userId]);
	}

	// Méthode pour récupérer l'utilisateur correspondant à la clé API
	public function getUserByApiKey(string $apiKey): ?array
	{
		$sql = "SELECT * FROM usager WHERE api_key = :cle_api";
		$query = $this->connection->prepare($sql);
		$query->execute(["cle_api" => $apiKey]);

		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result ? $result : null;
	}
}
