<?php
namespace Witte\Kanban\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Witte.Kanban".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use \Witte\Kanban\Domain\Model\Board;
use \Witte\Kanban\Domain\Model\SubColumn;

/**
 * A Column
 *
 * @Flow\Entity
 */
class SuperiorColumn {

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
	 * @var \Witte\Kanban\Domain\Model\Board
	 * @ORM\ManyToOne(inversedBy="superiorColumns")
	 */
	protected $board;

	/**
	 * The superiorColumn's limitValue
	 * @var integer
	 */
	protected $limitValue;

	/**
	 * The SubColumns contained in this superiorColumn
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\SubColumn>
	 * @ORM\OneToMany(mappedBy="superiorColumn", cascade={"remove"})
	 * @ORM\OrderBy({"sort" = "ASC"})
	 */
	protected $subColumns;

	/**
	 * The created
	 * @var \DateTime
	 */
	protected $created;

	public function __construct(){
		$this->setSort(0);
		$this->setLimitValue(0);
		$this->subColumns = new \Doctrine\Common\Collections\ArrayCollection();
		$this->created = new \DateTime();
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
	 * @param Board $board
	 */
	public function setBoard(Board $board)
	{
		$this->board = $board;
	}

	/**
	 * @return Board
	 */
	public function getBoard(){
		return $this->board;
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
	 * @param \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\SubColumn> $subColumns
	 */
	public function setSubColumns($subColumns)
	{
		$this->subColumns = $subColumns;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection<\Witte\Kanban\Domain\Model\SubColumn>
	 */
	public function getSubColumns()
	{
		return $this->subColumns;
	}

	/**
	 * @param SubColumn $subColumn
	 */
	public function addSubColumn(SubColumn $subColumn){
		$this->subColumns->add($subColumn);
	}

	/**
	 * @param SubColumn $subColumn
	 */
	public function removeSubColumn(SubColumn $subColumn){
		$this->subColumns->remove($subColumn);
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

}
?>