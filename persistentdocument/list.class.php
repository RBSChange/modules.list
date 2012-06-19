<?php
/**
 * list_persistentdocument_list
 * @package modules.list
 */
class list_persistentdocument_list extends list_persistentdocument_listbase
{
	/**
	 * @return string
	 */
	public function getLabel()
	{
		$label = parent::getLabel();
		$newKey = LocaleService::getInstance()->cleanOldKey($label);
		if ($newKey !== false)
		{
			return LocaleService::getInstance()->trans($newKey, array('ucf'));
		} 
		return LocaleService::getInstance()->trans($label, array('ucf'));
	}
	
	/**
	 * @return string
	 */
	public function getDescription()
	{
		$description = parent::getDescription();
		$newKey = LocaleService::getInstance()->cleanOldKey($description);
		if ($newKey !== false)
		{
			return LocaleService::getInstance()->trans($newKey);
		} 
		return LocaleService::getInstance()->trans($description);
	}
	
	/**
	 * @return list_Item[]
	 */
	public function getItems()
	{
		return array();	
	}
	
	/**
	 * @return integer
	 */
	public function countItems()
	{
		return count($this->getItems());
	}
	
	/**
	 * @return boolean
	 */
	public function canBeDeleted()
	{
		return f_util_StringUtils::beginsWith($this->getListid(), 'modules_webapp/usr');
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