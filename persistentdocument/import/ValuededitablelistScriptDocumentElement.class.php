<?php
/**
 * list_ValuededitablelistScriptDocumentElement
 * @package modules.list.persistentdocument.import
 */
class list_ValuededitablelistScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function initPersistentDocument()
	{
		$list = list_ListService::getInstance()->getByListId($this->attributes['listid']);
		if ($list === null)
		{
			$list = list_ValuededitablelistService::getInstance()->getNewDocumentInstance();
		}
		return $list;
	}
	
	/**
	 * @return array<String, String>
	 */
	protected function getDocumentProperties()
	{
		$attrs = $this->attributes;
		if (!isset($attrs["label"]) && isset($attrs['listid']))
		{
			$info = explode('/', $attrs['listid']);
			$attrs["label"] = $info[1];
		}
		$attrs['listid'] = strtolower($attrs['listid']);
		return $attrs;
	}
	
	public function endProcess()
	{
		$children = $this->script->getChildren($this);
		if (count($children))
		{
			$list = $this->getPersistentDocument();
			foreach ($children as $scriptElement)
			{
				if ($scriptElement instanceof list_ValueditemScriptDocumentElement)
				{
					$item = $scriptElement->getPersistentDocument();
					if (!$item->isNew())
					{
						$list->addItemdocuments($item);
					}
				}
			}
			$list->save();
		}
	}
	
	/**
	 * Check if an item labeled $label is in the list
	 * @param String $label
	 * @return Boolean true if label was founded
	 */
	public function checkLabel($label, $srcDocument = null)
	{
		foreach ($this->getPersistentDocument()->getItemdocumentsArray() as $document)
		{
			if ($document->getLabel() == $label && ($srcDocument === null || $document->getId() != $srcDocument->getId()))
			{
				return true;
			}
		}
		return false;
	}
}