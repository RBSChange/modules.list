<?php
/**
 * This service is just a sample used by the dynamic list define in sample.xml
 * @package modules.list
 */
class list_ListSampledynamicService implements list_ListItemsService
{
    /**
     * @var list_ListSampledynamicService
     */
	private static $instance = null;

	/**
	 * @return list_ListSampledynamicService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			$className = get_class();
			self::$instance = new $className;
		}
		return self::$instance;
	}

	/**
	 * Returns an array of list_Item representing the available "feeders" able to
	 * build a products list.
	 *
	 * @return Array<list_Item>
	 */
	public function getItems()
	{
		$itemArray = array();
		$itemArray[] = new list_Item('Test', '1');
		$itemArray[] = new list_Item('Exemple', '2');
		return $itemArray;
	}
}