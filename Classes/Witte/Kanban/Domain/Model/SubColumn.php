<?php
namespace Witte\Kanban\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\SuperiorColumn;
use \Witte\Kanban\Domain\Model\Ticket;

/**
 * A Column
 *
 * @Flow\Entity
 */
class SubColumn {

	/**
	 * The title
	 * @var string
	 */
	protected $title;

	/**
	 * The sort
	 * @var integer
	 */
	protected $sort;

	/**
	 * The created
	 * @var \DateTime
	 */
	protected $created;

	/**
	 * @var \Witte\Kanban\Domain\Model\SuperiorColumn
	 * @ORM\ManyToOne(inversedBy="subColumns")
	 */
	protected $superiorColumn;

	/**
	 * The Tickets contained in this subColumn
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Ticket>
	 * @ORM\OneToMany(mappedBy="subColumn", cascade={"remove"})
	 * @ORM\OrderBy({"moved" = "DESC"})
	 */
	protected $tickets;

	public function __construct(){
		$this->setSort(0);
		$this->created = new \DateTime();
		$this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Column's title
	 *
	 * @return string The Column's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this Column's title
	 *
	 * @param string $title The Column's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the Column's sort
	 *
	 * @return integer The Column's sort
	 */
	public function getSort() {
		return $this->sort;
	}

	/**
	 * Sets this Column's sort
	 *
	 * @param integer $sort The Column's sort
	 * @return void
	 */
	public function setSort($sort) {
		$this->sort = $sort;
	}

	/**
	 * @param \DateTime $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param SuperiorColumn $superiorColumn
	 */
	public function setSuperiorColumn($superiorColumn)
	{
		$this->superiorColumn = $superiorColumn;
	}

	/**
	 * @return SuperiorColumn
	 */
	public function getSuperiorColumn()
	{
		return $this->superiorColumn;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $tickets
	 */
	public function setTickets($tickets)
	{
		$this->tickets = $tickets;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getTickets()
	{
		return $this->tickets;
	}

	/**
	 * @param Ticket $ticket
	 */
	public function addTicket(Ticket $ticket){
		$this->tickets->add($ticket);
	}

	/**
	 * @param Ticket $ticket
	 */
	public function removeTicket(Ticket $ticket){
		$this->tickets->remove($ticket);
	}
}
?>