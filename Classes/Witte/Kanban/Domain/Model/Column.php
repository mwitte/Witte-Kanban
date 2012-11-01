<?php
namespace Witte\Kanban\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Column
 *
 * @Flow\Entity
 */
class Column {

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
	 * The superiorColumn's limitValue
	 * @var integer
	 */
	protected $limitValue;

	/**
	 * @var \Witte\Kanban\Domain\Model\Board
	 * @ORM\ManyToOne(inversedBy="columns")
	 */
	protected $board;

	/**
	 * @var \Witte\Kanban\Domain\Model\Column
	 * @ORM\ManyToOne(inversedBy="subColumns")
	 */
	protected $parentColumn;

	/**
	 * The Tickets contained in this subColumn
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Ticket>
	 * @ORM\OneToMany(mappedBy="slot", cascade={"remove"})
	 * @ORM\OrderBy({"moved" = "DESC"})
	 */
	protected $tickets;

	/**
	 * The Columns contained in this Column
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Column>
	 * @ORM\OneToMany(mappedBy="parentColumn", cascade={"remove"})
	 * @ORM\OrderBy({"sort" = "ASC"})
	 */
	protected $subColumns;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\ColumnService
	 */
	protected $columnService;

	/**
	 * @Flow\Inject
	 * @var \Witte\Kanban\Domain\Service\BoardService
	 */
	protected $boardService;

	public function __construct(){
		$this->setSort(0);
		$this->setLimitValue(0);
		$this->subColumns = new \Doctrine\Common\Collections\ArrayCollection();
		$this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
		$this->created = new \DateTime();
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Board $board
	 */
	public function setBoard($board)
	{
		$this->board = $board;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Board
	 */
	public function getBoard()
	{
		return $this->board;
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
	 * @param int $limitValue
	 */
	public function setLimitValue($limitValue)
	{
		$this->limitValue = $limitValue;
	}

	/**
	 * @return int
	 */
	public function getLimitValue()
	{
		return $this->limitValue;
	}

	/**
	 * @param \Witte\Kanban\Domain\Model\Column $parentColumn
	 */
	public function setParentColumn($parentColumn)
	{
		$this->parentColumn = $parentColumn;
	}

	/**
	 * @return \Witte\Kanban\Domain\Model\Column
	 */
	public function getParentColumn()
	{
		return $this->parentColumn;
	}

	/**
	 * @param Column $column
	 */
	public function addSubColumn(Column $column){
		$this->subColumns->add($column);
	}

	/**
	 * @param Column $column
	 */
	public function removeSubColumn(Column $column){
		$this->subColumns->removeElement($column);
	}

	/**
	 * @param int $sort
	 */
	public function setSort($sort)
	{
		$this->sort = $sort;
	}

	/**
	 * @return int
	 */
	public function getSort()
	{
		return $this->sort;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $subColumns
	 */
	public function setSubColumns($subColumns)
	{
		$this->subColumns = $subColumns;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getSubColumns()
	{
		return $this->subColumns;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $tickets
	 */
	public function setTickets($tickets)
	{
		$this->tickets = $tickets;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\Ticket>
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
		$this->tickets->removeElement($ticket);
	}

	public function getColumnWith(){
		return $this->columnService->getColumnWidth($this);
	}

	public function getIsFirst(){
		return $this->columnService->isFirstColumnInBoard($this);
	}

	public function getIsLast(){
		return $this->columnService->isLastColumnInBoard($this);
	}
}
?>