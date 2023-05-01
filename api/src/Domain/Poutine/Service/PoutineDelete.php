<?php

namespace App\Domain\Poutine\Service;

use App\Domain\Poutine\Repository\PoutineRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use stdClass;

/**
 * Service.
 */
final class PoutineDelete
{
    /**
     * @var PoutineRepository
     */
    private $repository;
    
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(PoutineRepository $repository, LoggerFactory $loggerFactory)
    {
        $this->repository = $repository;
        $this->logger = $loggerFactory
            ->addFileHandler('PoutineLog.log')
            ->createLogger('deletePoutine');
    }

    /**
     * Supprime une poutine dans la base de données.
     * 
     * @param int $idPoutine Le id de la poutine à supprimer
     *
     * @return array La poutine supprimée
     */
    public function removepoutine(int $idPoutine): array
    {

        // Je vais chercher les informations de la poutine a supprimer
        // Pour valider qu'ielle existe bien et aussi pour les retourner à l'usager après la suppression
        $poutineToDelete = $this->repository->selectPoutineById($idPoutine);
        // Par défaut le code de statut sera 200 - Succès
        $codeStatus = 200;

        // Si la poutine n'existe pas on change pour le code 404, sinon on supprime la poutine
        if(empty($poutineToDelete)) {
            $codeStatus = 404;
        } else {
            if($this->repository->deletePoutine($idPoutine)) {
                $this->logger->info('La poutine "' . $poutineToDelete['nom'] . '" id [' . $idPoutine . '] a été supprimé.');
            }
        }
        
        // Si le film n'existe pas, on retourne un objet vide
        // J'ai créer un tableau avec la poutine et le code de statut pour pouvoir les retourner tous les deux avec ma fonction
        $resultat = [
            "movie" => empty($poutineToDelete) ? new stdClass : $poutineToDelete,
            "codeStatus" => $codeStatus
        ];

        return $resultat;
    }


}
