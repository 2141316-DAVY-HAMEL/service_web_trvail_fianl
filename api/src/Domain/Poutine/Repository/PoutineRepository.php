<?php

namespace App\Domain\Poutine\Repository;

use PDO;

/**
 * Repository.
 */
class PoutineRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Sélectionne la liste de tous les poutines
     * 
     * @return array
     */
    public function selectAllPoutines(): array
    {
        $sql = "SELECT * FROM poutine";
           

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne les informations d'une poutine
     * 
     * @param int $poutineId Le id de la poutine à afficher
     * 
     * @return array Les informations de la poutine
     */
    public function selectPoutineById(int $poutineId): array
    {
        $sql = "SELECT * FROM poutine WHERE id = :id;";
        $params = [
            'id' => $poutineId
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result[0] ?? [];
    }



    /**
     * Ajoute une poutine
     * 
     * @param array $data Les données de la poutine
     * 
     * @return array Les informations de la poutine ajouté avec son id
     */
    public function createPoutine(array $data): array
    {
        $sql = "INSERT INTO poutine (nom, description)
                VALUES (:nom, :description);
        ";
        
        $params = [
            "nom" => $data['nom'] ?? "",
            "description"=> $data['description'] ?? ""
        ];

        $query = $this->connection->prepare($sql);
        // L'insertion est fait ici
        $query->execute($params);
        // Je récupère le id qui vient d'être créé
        $movieId = $this->connection->lastInsertId();
        // Je veux retourner à l'usager la poutine créé avec le nouveau id, je me sers de la fonction que j'ai
        // déjà pour sélectionner une poutine par son id. En même temps ça me prouve qu'elle est bien créé.
        // C'est pas à toute épreuve comme gestion d'erreur mais pour l'instant on ne s'en occupe pas.
        $result = $this->selectPoutineById($movieId);

        return $result;
    }

    /**
     * Modifie une poutine
     * 
     * @param int $id Le id de la poutine à modifier
     * @param array $data Les données de la poutine à modifier
     * 
     * @return array La poutine modifié
     */
    public function updatePoutine(int $id, array $data): array
    {
        
        $sql = "UPDATE poutine
                SET nom = :nom, 
                    description = :description
                WHERE id = :id;";
        
        $params = [
            "id" => $id,
            "nom" => $data['nom'] ?? "",
            "description"=> $data['description'] ?? ""
        ];
        
        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $this->selectPoutineById($id);

        return $result;
    }

    /**
     * Supprime une poutine selon son id
     *
     * @param int $poutineId Le id de la poutine à supprimer
     *
     * @return bool La suppression à réussi
     */
    public function deletePoutine(int $poutineId): bool
    {
        $params = ['id' => $poutineId];
        $sql = "DELETE FROM poutine WHERE id = :id";

        $query = $this->connection->prepare($sql);
        $result = $query->execute($params);

        return $result;
    }
}

