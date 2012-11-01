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
 * @Flow\Scope("singleton")
 */
abstract class AbstractService {

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\BoardRepository
	 */
	protected $boardRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\ColumnRepository
	 */
	protected $columnRepository;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Repository\TicketRepository
	 */
	protected $ticketRepository;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Inject the settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * @param $count
	 * @return float
	 */
	protected function getQuotient($count){
		return floor($this->settings['TwitterBootstrap']['Columns'] / $count);
	}
}
?>