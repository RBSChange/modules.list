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
	 * @param String $label
	 * @param String $type
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function getChildDocumentByProperty($propName, $propValue, $type)
	{
		$persistentProvider = f_persistentdocument_PersistentProvider::getInstance();
		$query = $persistentProvider->createQuery($type)->add(Restrictions::eq($propName, $propValue));
		
		$parentDoc = $this->getParentInTree();
		if ($parentDoc !== null)
		{
			$query->add(Restrictions::eq("valuededitablelist.listid", $parentDoc->getListid()));
		}

		$documents = $query->find();
		if (count($documents) > 0)
		{
			// FIXME: what if multiple documents ? Shouldn't we throw something ?
			return $documents[0];
		}

		return null;
	}

    /**
     * @return import_ScriptDocumentElement
     */
    protected function getParentDocument()
    {
        return $this->getParentByClassName('list_ValuededitablelistScriptDocumentElement');
    }
    
    /**
     * @return list_ValuededitablelistScriptDocumentElement
     */
    private function getParentList()
    {
    	return $this->getParentByClassName("list_ValuededitablelistScriptDocumentElement");
    }
    
    protected function saveDocument()
    {
        $list = $this->getParentList();
        $document = $this->getPersistentDocument();
        if (!$list || !$list->checkLabel($document->getLabel(), $document))
        {
            parent::saveDocument();    
        }
    }
    
}