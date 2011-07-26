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
		return $this->getAncestorByClassName('list_EditablelistScriptDocumentElement');
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_list/item');
	}
	
	/**
	 * @param String $label
	 * @param String $type
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function getChildDocumentByProperty($propName, $propValue, $type)
	{
		
		$persistentProvider = f_persistentdocument_PersistentProvider::getInstance();
		$query = $persistentProvider->createQuery($type)->add(Restrictions::eq($propName, $propValue));
		
		$parentDoc = $this->getParentDocument()->getPersistentDocument();
		if ($parentDoc !== null)
		{
			$query->add(Restrictions::eq('editablelist', $parentDoc));
		}
		
		$documents = $query->find();
		if (count($documents) > 0)
		{
			// FIXME: what if multiple documents ? Shouldn't we throw something ?
			return $documents[0];
		}
		return null;
	}
}