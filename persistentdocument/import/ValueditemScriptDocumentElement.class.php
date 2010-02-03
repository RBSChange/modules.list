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
        if (!$list || !$list->checkLabel($document->getLabel()))
        {
            parent::saveDocument();    
        }
    }
    
}