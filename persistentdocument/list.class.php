<?php
/**
 * list_persistentdocument_list
 * @package modules.list
 */
class list_persistentdocument_list extends list_persistentdocument_listbase
{
	
	/**
	 * @see f_persistentdocument_PersistentDocumentImpl::getLabel()
	 *
	 * @return String
	 */
	public function getLabel()
	{
		$label = parent::getLabel();
		if (f_Locale::isLocaleKey($label))
		{
			return f_Locale::translateUI($label);
		}
		return $label;
	}
	
	/**
	 * @see list_persistentdocument_listbase::getDescription()
	 *
	 * @return String
	 */
	public function getDescription()
	{
		$description = parent::getDescription();
		if (f_Locale::isLocaleKey($description))
		{
			return f_Locale::translateUI($description);
		}
		return $description;
	}
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