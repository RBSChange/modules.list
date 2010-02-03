<?php
/**
 * list_ItemScriptDocumentElement
 * @package modules.list.persistentdocument.import
 */
class list_ItemScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return list_persistentdocument_item
	 */
	protected function initPersistentDocument()
	{
		return list_ItemService::getInstance()->getNewDocumentInstance();
	}
	
	/**
	 * @return import_ScriptDocumentElement
	 */
	protected function getParentDocument()
	{
		return $this->getParentByClassName('list_EditablelistScriptDocumentElement');
	}
	
	/**
	 * @return void
	 */
	protected function saveDocument()
	{
		$list = $this->getParentDocument();
		$document = $this->getPersistentDocument();
		if (!$list || !$list->checkLabel($document->getLabel()))
		{
			parent::saveDocument();
		}
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_list/item');
	}
}