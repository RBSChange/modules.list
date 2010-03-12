<?php
class list_persistentdocument_staticlist extends list_persistentdocument_staticlistbase
{
	/**
	 * @var String
	 */
	private $deserializedValues;
	
	/**
	 * @param String $value the serialized array of items.
	 */
	public function setItemvalues($value)
	{
		$this->deserializedValues = null;
		parent::setItemvalues($value);
	}
	
	/**
	 * Return the list of items. Use the property itemvalues to extract of the serialized string the list of items
	 * @return array of list_Item
	 */
	public function getItems()
	{
		if ($this->deserializedValues !== null)
		{
			return $this->deserializedValues;
		}
		$itemvalues = $this->getItemvalues();
		if (is_string($itemvalues))
		{
			$this->deserializedValues = unserialize($itemvalues);
		}
		else
		{
			$this->deserializedValues = array();	
		}
		return $this->deserializedValues;
	}
}