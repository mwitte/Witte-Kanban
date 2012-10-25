<?php
namespace Witte\Kanban\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\Ticket;
use \Witte\Kanban\Domain\Model\SubColumn;
use \Witte\Kanban\Domain\Service\AbstractService;

/**
 * Service
 *
 * @Flow\Scope("prototype")
 */
class SubColumnService extends AbstractService {


	public function createSubColumnDependencies(SubColumn $subColumn){
		$this->subColumnRepository->add($subColumn);
	}
}
?>