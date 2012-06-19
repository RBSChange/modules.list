<?php
/**
 * @package modules.list
 * @method list_ListSampledynamicService getInstance()
 * @todo Sample? Deprecate?
 */
class list_ListSampledynamicService extends change_BaseService implements list_ListItemsService
{
	/**
	 * Returns an array of list_Item representing the available "feeders" able to
	 * build a products list.
	 *
	 * @return list_Item[]
	 */
	public function getItems()
	{
		$itemArray = array();
		$itemArray[] = new list_Item('Test', '1');
		$itemArray[] = new list_Item('Exemple', '2');
		return $itemArray;
	}
}