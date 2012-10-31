<?php
namespace Witte\Kanban\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\SuperiorColumn;

/**
 * A Board
 *
 * @Flow\Entity
 */
class Board {

	/**
	 * The title
	 * @var string
	 */
	protected $title;

	/**
	 * The superiorColumns contained in this board
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\SuperiorColumn>
	 * @ORM\OneToMany(mappedBy="board", cascade={"remove", "persist"})
	 * @ORM\OrderBy({"sort" = "ASC"})
	 */
	protected $superiorColumns;

	/**
	 * The archived tickets contained in this board
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Ticket>
	 * @ORM\OneToMany(mappedBy="board", cascade={"remove", "persist"})
	 * @ORM\OrderBy({"moved" = "DESC"})
	 */
	protected $ticketArchive;

	/**
	 * The created
	 * @var \DateTime
	 */
	protected $created;


	public function __construct(){
		$this->superiorColumns = new \Doctrine\Common\Collections\ArrayCollection();
		$this->created = new \DateTime();
	}

	/**
	 * Get the Board's title
	 *
	 * @return string The Board's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this Board's title
	 *
	 * @param string $title The Board's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the Board's superiorColumns
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\SuperiorColumn> The Board's superiorColumns
	 */
	public function getSuperiorColumns() {
		return $this->superiorColumns;
	}

	/**
	 * Sets this Board's superiorColumns
	 *
	 * @param \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\SuperiorColumn> $superiorColumns The Board's superiorColumns
	 * @return void
	 */
	public function setSuperiorColumns(SuperiorColumn $superiorColumns) {
		$this->superiorColumns = $superiorColumns;
	}

	/**
	 * @param SuperiorColumn $superiorColumn
	 */
	public function addSuperiorColumn(SuperiorColumn $superiorColumn){
		$this->superiorColumns->add($superiorColumn);
	}

	/**
	 * @param SuperiorColumn $superiorColumn
	 */
	public function removeSuperiorColumn(SuperiorColumn $superiorColumn){
		$this->superiorColumns->removeElement($superiorColumn);
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
	 * @param \Doctrine\Common\Collections\Collection $ticketArchive
	 */
	public function setTicketArchive($ticketArchive)
	{
		$this->ticketArchive = $ticketArchive;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getTicketArchive()
	{
		return $this->ticketArchive;
	}

	public function addToTicketArchive(Ticket $ticket){
		$this->ticketArchive->add($ticket);
	}

	public function removeFromTicketArchive(Ticket $ticket){
		$this->ticketArchive->removeElement($ticket);
	}

}
?>