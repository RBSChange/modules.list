<?php
/**
 * list_EditablelistScriptDocumentElement
 * @package modules.list.persistentdocument.import
 */
class list_EditablelistScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function initPersistentDocument()
	{
		$listid = $this->attributes['listid'];
		try
		{
			return list_ListService::getInstance()->getDocumentInstanceByListId($listid);
		}
		catch (Exception $e)
		{
			return list_EditablelistService::getInstance()->getNewDocumentInstance();
		}
	}
	
	public function endProcess()
	{
		$children = $this->script->getChildren($this);
		if (count($children))
		{
			$list = $this->getPersistentDocument();
			foreach ($children as $scriptElement)
			{
				if ($scriptElement instanceof list_EditableitemScriptDocumentElement)
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
	 * @return Boolean true if label was found
	 */
	public function checkLabel($label)
	{
		foreach ($this->getPersistentDocument()->getItemdocumentsArray() as $document)
		{
			if ($document->getLabel() == $label)
			{
				return true;
			}
		}
		return false;
	}
}