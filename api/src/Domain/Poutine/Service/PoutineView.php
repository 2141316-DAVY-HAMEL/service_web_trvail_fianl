<?php

namespace App\Domain\Poutine\Service;

use App\Domain\Poutine\Repository\PoutineRepository;

/**
 * Service.
 */
final class PoutineView
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
     * Sélectionne tous les poutines.
     *
     * @return array La liste des poutines
     */
    public function viewAllPoutines(array $queryParams): array
    {

        $poutine = $this->repository->selectAllPoutines();

        // Tableau qui contient la réponse à retourner à l'usager
        $resultat = [
            "poutine" => $poutine,
        ];

        return $resultat;
    }


}
