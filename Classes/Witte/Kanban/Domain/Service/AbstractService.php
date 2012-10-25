<?php
namespace Witte\Kanban\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @Flow\Scope("prototype")
 */
abstract class AbstractService {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\BoardRepository
	 */
	protected $boardRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\SuperiorColumnRepository
	 */
	protected $superiorColumnRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\SubColumnRepository
	 */
	protected $subColumnRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\TicketRepository
	 */
	protected $ticketRepository;
}
?>