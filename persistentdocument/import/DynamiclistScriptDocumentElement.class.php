<?php
/**
 * list_DynamiclistScriptDocumentElement
 * @package modules.list.persistentdocument.import
 */
class list_DynamiclistScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function initPersistentDocument()
	{
		$list = list_ListService::getInstance()->getByListId($this->attributes['listid']);
		if ($list === null)
		{
			$list = list_DynamiclistService::getInstance()->getNewDocumentInstance();
		}
		return $list;
	}
}