<?php
/**
 * list_persistentdocument_dynamiclist
 * @package modules.list
 */
class list_persistentdocument_dynamiclist extends list_persistentdocument_dynamiclistbase
{
	/**
	 * Return the list of items. Use an external class to find the list of items.
	 * @return array of list_Item
	 */
	public function getItems()
	{
		$listService = $this->getListService();
		return $listService->getItems();
	}
	
	/**
	 * @param string $value;
	 * @return list_Item
	 */
	public function getItemByValue($value)
	{
		$listService = $this->getListService();
		if (f_util_ClassUtils::methodExists($listService, 'getItemByValue'))
		{
			return $listService->getItemByValue($value);
		}
		return parent::getItemByValue($value);
	}
	
	/**
	 * @return list_ListItemsService
	 */
	private function getListService()
	{
		// Get the list Id to construct the classname for the call service
		$listName = $this->getListid();
		
		// Extract data
		list($package, $listId) = explode('/', $listName);
		list(, $moduleName) = explode('_', $package);
		
		// Construct classname
		$className = $moduleName . '_List' . ucfirst($listId) . 'Service';
		
		// Get instance of class
		$listService = f_util_ClassUtils::callMethod($className, 'getInstance');
		
		// Set the parameters if possible.
		if (f_util_ClassUtils::methodExists($listService, 'setParameters'))
		{
			$listService->setParameters($this->parameters);
		}

		return $listService;
	}
	
	/**
	 * @var Array
	 */
	private $parameters = array();
	
	/**
	 * @param Array $parameters
	 */
	public function setParameters($parameters)
	{
		$this->checkLoaded();
		$this->parameters = $parameters;
	}
}