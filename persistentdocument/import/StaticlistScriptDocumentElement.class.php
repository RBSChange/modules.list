<?php
/**
 * list_StaticlistScriptDocumentElement
 * @package modules.list.persistentdocument.import
 */
class list_StaticlistScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function initPersistentDocument()
	{
		$list = list_ListService::getInstance()->getByListId($this->attributes['listid']);
		if ($list === null)
		{
			$list = list_StaticlistService::getInstance()->getNewDocumentInstance();
		}
		return $list;
	}
	
	protected function saveDocument()
	{
		$document = $this->getPersistentDocument();
		if ($document->isNew())
		{
			parent::saveDocument();
		}
	}
	
	public function endProcess()
	{
		$list = $this->getPersistentDocument();
		$children = $this->script->getChildren($this);
		
		$items = array();
		if (count($children))
		{
			foreach ($children as $scriptElement)
			{
				if ($scriptElement instanceof list_StaticitemElement)
				{
					$items[] = $scriptElement->getStaticItem();
				}
			}
		}
		
		$list->setItemvalues(serialize($items));
		if ($list->isModified())
		{
			$list->save();
		}
	}
}