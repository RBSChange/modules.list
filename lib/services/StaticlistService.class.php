<?php
/**
 * @date Mon Apr 23 16:48:14 CEST 2007
 * @author INTcoutL
 */
class list_StaticlistService extends list_ListService
{
	/**
	 * @var list_StaticlistService
	 */
	private static $instance;

	/**
	 * @return list_StaticlistService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @return list_persistentdocument_staticlist
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_list/staticlist');
	}

	/**
	 * Create a query based on 'modules_list/staticlist' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_list/staticlist');
	}

	/**
	 * Returns the label of an item from its value for the given $list.
	 * If no item matches the given value, null is returned.
	 *
	 * @param list_persistentdocument_staticlist $list
	 * @param String $itemValue
	 * @return String
	 */
	public function getItemLabel($list, $itemValue)
	{
		foreach ($list->getItems() as $item)
		{
			if ($item->getValue() == $itemValue)
			{
				return $item->getLabel();
			}
		}
		return null;
	}
}
