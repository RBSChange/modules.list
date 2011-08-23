<?php
/**
 * @date Mon Apr 23 16:48:14 CEST 2007
 * @author INTcoutL
 */
class list_DynamiclistService extends list_ListService
{
	/**
	 * @var list_DynamiclistService
	 */
	private static $instance;
	
	/**
	 * @return list_DynamiclistService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
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
		return $this->pp->createQuery('modules_list/dynamiclist');
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