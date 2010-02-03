<?php
/**
 * list_persistentdocument_list
 * @package modules.list
 */
class list_persistentdocument_list extends list_persistentdocument_listbase
{
    /**
     * @return list_Item[]
     */
	public function getItems()
	{
		return array();	
	}
	
	/**
	 * @return Integer
	 */
	public function countItems()
	{
	    return count($this->getItems());
	}
	
	/**
	 * @return Boolean
	 */
	public function canBeDeleted()
	{
		return f_util_StringUtils::beginsWith($this->getListid(), 'modules_webapp/usr');
	}
	
	/**
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */	
	protected function addTreeAttributes($moduleName, $treeType, &$nodeAttributes)
	{
	    $nodeAttributes['listid'] = $this->getListid();
	    $nodeAttributes['canBeDeleted'] = ($this->canBeDeleted() ? 'true' : 'false');
	    try 
	    {
	        $nodeAttributes['nbitems'] = $this->countItems();
	    } 
	    catch (Exception $e)
	    {
	        $nodeAttributes['nbitems'] = '-';
	    }
	}
	
	/**
	 * @param string $value;
	 * @return list_Item
	 */
	public function getItemByValue($value)
	{
		try 
		{
			$items = $this->getItems();
			if (count($items) > 0)
			{
				foreach ($items as $item) 
				{
					if ($item->getValue() == $value)
					{
						return $item;
					}
				}
			}
		} 
		catch (Exception $e)
		{
			Framework::exception($e);
		}
		return null;
	}
	
	/**
	 * @param Array $parameters
	 */
	public function setParameters($parameters)
	{
		// Do nothing.
	}
}