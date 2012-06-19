<?php
/**
 * list_ListScriptDocumentElement
 * @package modules.list.persistentdocument.import
 */
class list_ListScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return list_persistentdocument_list
	 */
	protected function initPersistentDocument()
	{
		return list_ListService::getInstance()->getNewDocumentInstance();
	}
}