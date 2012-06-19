<?php
/**
 * @package modules.list
 * @method list_DynamiclistService getInstance()
 */
class list_DynamiclistService extends list_ListService
{
	/**
	 * @return list_persistentdocument_dynamiclist
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_list/dynamiclist');
	}
	
	/**
	 * Create a query based on 'modules_list/dynamiclist' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_list/dynamiclist');
	}
	
	/**
	 * @param list_persistentdocument_list $document
	 * @return boolean true if the document is publishable, false if it is not.
	 */
	public function isPublishable($document)
	{
		return true;
	}
}