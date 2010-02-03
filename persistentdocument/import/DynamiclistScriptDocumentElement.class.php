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
        $listid = $this->attributes['listid'];
        try 
        {
            return list_ListService::getInstance()->getDocumentInstanceByListId($listid);
        } 
        catch (Exception $e)
        {
            return  list_DynamiclistService::getInstance()->getNewDocumentInstance();
        } 
    }    
}