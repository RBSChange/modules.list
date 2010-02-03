<?php
/**
 * list_persistentdocument_valuededitablelist
 * @package modules.list
 */
class list_persistentdocument_valuededitablelist extends list_persistentdocument_valuededitablelistbase
{
	/**
	 * @param list_persistentdocument_item $item
	 */
	protected function buildListItem($item)
	{
		$isContextLangAvailable = $item->isContextLangAvailable();
		$label = $isContextLangAvailable ? $item->getLabel() : $item->getVoLabel();
		return new list_Item($label, $item->getValue());
	}
	
	/**
	 * @param string $value;
	 * @return list_Item
	 */
	public function getItemByValue($value)
	{
		try 
		{
			$item = list_ValueditemService::getInstance()->createQuery()
				->add(Restrictions::eq('list.id', $this->getId()))
				->add(Restrictions::eq('value', $value))
				->findUnique();
			return $this->buildListItem($item);
		} 
		catch (Exception $e)
		{
			Framework::exception($e);
		}
		return null;
	}
	
	/**
	 * @var string
	 */
	private $newItemValue;
	
	/**
	 * @return string
	 */
	public function getNewItemValue()
	{
		$this->checkLoaded();
		return $this->newItemValue;
	}
	
	/**
	 * @param string $newItemValue
	 */
	public function setNewItemValue($newItemValue)
	{
		$this->setModificationdate(null);
		$this->newItemValue = $newItemValue;
	}
}