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
		$list = list_ListService::getInstance()->getByListId($this->attributes['listid']);
		if ($list === null)
		{
			$list = list_EditablelistService::getInstance()->getNewDocumentInstance();
		}
		return $list;
	}
	
	public function endProcess()
	{
		$children = $this->script->getChildren($this);
		if (count($children))
		{
			$list = $this->getPersistentDocument();
			foreach ($children as $scriptElement)
			{
				if ($scriptElement instanceof list_ItemScriptDocumentElement)
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
}