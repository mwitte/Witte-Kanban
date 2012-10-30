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
use \Witte\Kanban\Domain\Model\SuperiorColumn;
use \Witte\Kanban\Domain\Service\AbstractService;

/**
 * Service
 *
 * @Flow\Scope("singleton")
 */
class SubColumnService extends AbstractService {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\SuperiorColumnService
	 */
	protected $superiorColumnService;

	public function getPreviousSubColumn(SubColumn $subColumn){
		$subColumns = $subColumn->getSuperiorColumn()->getSubColumns();

		// if the subColumn is not the first
		if($subColumns->indexOf($subColumn) > 0){
			// get the previous subColumn contained in the same superiorColumn
			$previousSubColumn = $subColumns->get($subColumns->indexOf($subColumn) - 1);
		}else{
			$previousSuperiorColumn = $this->superiorColumnService->getPreviousSuperiorColumn($subColumn->getSuperiorColumn());
			if($previousSuperiorColumn){
				$previousSubColumn = $previousSuperiorColumn->getSubColumns()->last();
			}else{
				$previousSubColumn = FALSE;
			}
		}
		return $previousSubColumn;
	}

	public function getNextSubColumn(SubColumn $subColumn){
		$subColumns = $subColumn->getSuperiorColumn()->getSubColumns();

		if($subColumns->last() != $subColumn){
			$nextSubColumn = $subColumns->get($subColumns->indexOf($subColumn) + 1);
		}else{
			$nextSuperiorColumn = $this->superiorColumnService->getNextSuperiorColumn($subColumn->getSuperiorColumn());
			if($nextSuperiorColumn){
				$nextSubColumn = $nextSuperiorColumn->getSubColumns()->first();
			}else{
				$nextSubColumn = FALSE;
			}
		}
		return $nextSubColumn;
	}

	public function createSubColumnDependencies(SubColumn $subColumn){
		$this->subColumnRepository->add($subColumn);
	}

	/**
	 * @param SuperiorColumn $superiorColumn
	 * @return float
	 */
	public function getQuotientBySuperiorColumn(SuperiorColumn $superiorColumn){
		return $this->getQuotient($superiorColumn->getSubColumns()->count());
	}
}
?>