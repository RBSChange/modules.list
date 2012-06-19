<?php
/**
 * @package modules.list
 * @method list_StaticlistService getInstance()
 */
class list_StaticlistService extends list_ListService
{
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
		return $this->getPersistentProvider()->createQuery('modules_list/staticlist');
	}

	/**
	 * Returns the label of an item from its value for the given $list.
	 * If no item matches the given value, null is returned.
	 *
	 * @param list_persistentdocument_staticlist $list
	 * @param string $itemValue
	 * @return string
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
