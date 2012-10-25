<?php
namespace Witte\Kanban\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\SuperiorColumn;
use \Witte\Kanban\Domain\Model\SubColumn;
use \Witte\Kanban\Domain\Service\AbstractService;

/**
 * Service
 *
 * @Flow\Scope("prototype")
 */
class SuperiorColumnService extends AbstractService {


	/**
	 * @param SuperiorColumn $superiorColumn
	 */
	public function createSuperiorColumnDependencies(SuperiorColumn $superiorColumn){

		$subColumnService = new SubColumnService();

		$subColumn = new SubColumn();
		$subColumn->setTitle('doing');
		$subColumn->setSuperiorColumn($superiorColumn);
		$superiorColumn->addSubColumn($subColumn);
		$subColumnService->createSubColumnDependencies($subColumn);


		$this->superiorColumnRepository->add($superiorColumn);
	}
}
?>