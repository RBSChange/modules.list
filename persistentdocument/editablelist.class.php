<?php
/**
 * list_persistentdocument_editablelist
 * @package modules.list
 */
class list_persistentdocument_editablelist extends list_persistentdocument_editablelistbase
{
	/**
	 * Return the list of items. This list is based on the property itemdocuments of model
	 *
	 * @return array of list_Item
	 */
	public function getItems()
	{
		// Load list of item
		$itemdocuments = $this->getItemdocumentsArray();

		// Get the order info
		$order = $this->getOrder();

		$listOfItems = array();
		// Foreach item create an object list_Item
		foreach ($itemdocuments as $item)
		{
			if ($item->isContextLangAvailable())
			{
				if (!$item->isPublished())
				{
					continue;
				}
			}
			else if (!$this->getUseVoIfNotTranslated() || $item->getVoPublicationstatus() != 'PUBLICATED')
			{
				continue;
			}
			
			$tmp = $this->buildListItem($item);
			$listOfItems[f_util_StringUtils::strip_accents($tmp->getLabel())] = $tmp;
		}
		// if  order == 1 make a natural order
		if($order)
		{
			ksort($listOfItems);
		}

		// Return the list of list_Item
		return $listOfItems;
	}

	/**
	 * @return Integer
	 */
	public function countItems()
	{
		return $this->getItemdocumentsCount();
	}
	
	/**
	 * @param string $value;
	 * @return list_Item
	 */
	public function getItemByValue($value)
	{
		try 
		{
			return $this->buildListItem(DocumentHelper::getDocumentInstance($value));
		} 
		catch (Exception $e)
		{
			Framework::exception($e);
		}
		return null;
	}
	
	/**
	 * @param list_persistentdocument_item $item
	 */
	protected function buildListItem($item)
	{
		$label = $item->isContextLangAvailable() ? $item->getLabel() : $item->getVoLabel();
		return new list_Item($label, $item->getId());
	}
	
	private $newItemLabel;
	
	/**
	 * @param string $val
	 */
	public function setNewItemLabel($val)
	{
		$this->setModificationdate(null);
		$this->newItemLabel = $val;
	}
	
	/**
	 * @return string
	 */
	public function getNewItemLabel()
	{
		$this->checkLoaded();
		return $this->newItemLabel;
	}	
}