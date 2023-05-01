<?php

namespace App\Domain\Poutine\Service;

use App\Domain\Poutine\Repository\PoutineRepository;

/**
 * Service.
 */
final class PoutineUpdate
{
    /**
     * @var PoutineRepository
     */
    private $repository;

    public function __construct(PoutineRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Modification d'un film dans la base de données.
     * 
     * @param int $id Le id de la poutine à modifier
     * @param array $data Les informations à modifier
     *
     * @return array La poutine ajouté
     */
    public function updatePoutine(int $id, array $data): array
    {

        // L'idée avec la méthode PUT est que si la ressource à modifier n'existe pas, on doit la créer.
        
        // Teste si la poutine existe dans la base de données
        $viellePoutine = $this->repository->selectPoutineById($id);
        $codeStatus = 200;

        if(empty($viellePoutine)) {
            // Création d'une nouvelle poutine
            $poutines = $this->repository->createPoutine($data);
            $codeStatus = 201;   
        } else {
            // Modification de la poutine existant
	        $poutines = $this->repository->updatePoutine($id, $data);
        }

        $resultat = [
            "poutine" => $poutines,
            "codeStatus" => $codeStatus
        ];

        return $resultat;
    }


}
