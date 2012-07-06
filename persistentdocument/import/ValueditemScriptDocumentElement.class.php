<?php
/**
 * list_ValueditemScriptDocumentElement
 * @package modules.list.persistentdocument.import
 */
class list_ValueditemScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function initPersistentDocument()
	{
		return list_ValueditemService::getInstance()->getNewDocumentInstance();
	}  

	/**
	 * @return import_ScriptDocumentElement
	 */
	protected function getParentDocument()
	{
		return $this->getAncestorByClassName('list_ValuededitablelistScriptDocumentElement');
	}
	
	/**
	 * @param string $label
	 * @param string $type
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function getChildDocumentByProperty($propName, $propValue, $type)
	{
		
		$persistentProvider = f_persistentdocument_PersistentProvider::getInstance();
		$query = $persistentProvider->createQuery($type)->add(Restrictions::eq($propName, $propValue));
		
		$parentDoc = $this->getParentDocument()->getPersistentDocument();
		if ($parentDoc !== null)
		{
			$query->add(Restrictions::eq('valuededitablelist', $parentDoc));
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