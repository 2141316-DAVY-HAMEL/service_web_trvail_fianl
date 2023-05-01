<?php

namespace App\Domain\Poutine\Service;

use App\Domain\Poutine\Repository\PoutineRepository;

/**
 * Service.
 */
final class PoutineCreate
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
     * Ajout d'une poutine dans la base de données.
     * 
     * @param array $data Les informations à ajouter
     *
     * @return array La poutine ajouté
     */
    public function addPoutine(array $data): array
    {

        $poutines = $this->repository->createPoutine($data);

        return $poutines ?? [];
    }


}
