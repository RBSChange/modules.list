<?php
/**
 * @date Mon Apr 23 16:48:14 CEST 2007
 * @author INTcoutL
 */
class list_EditablelistService extends list_ListService
{
	
	/**
	 * @var list_EditablelistService
	 */
	private static $instance;
	
	/**
	 * @return list_EditablelistService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}
	
	/**
	 * @return list_persistentdocument_editablelist
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_list/editablelist');
	}
	
	/**
	 * Create a query based on 'modules_list/editablelist' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_list/editablelist');
	}
	
	/**
	 * @param list_persistentdocument_editablelist $document
	 */
	protected function preDelete($document)
	{
		if ($document->countItems() > 0)
		{
			throw new IllegalOperationException('Document list cannot be deleted because it has items');
		}
		if (($count = $this->countReferences($document)) > 0)
		{
			throw new IllegalOperationException('Document list cannot be deleted be cause it is used in ' . $count . ' document(s)');
		}
	}
	
	/**
	 * @param list_persistentdocument_editablelist $document
	 */
	protected function postDelete($document)
	{
		$items = $document->getItemdocumentsArray();
		foreach ($items as $item)
		{
			if ($item instanceof list_persistentdocument_item)
			{
				$item->delete();
			}
		}
	}
	
	/**
	 * @param list_persistentdocument_editablelist $document
	 * @param Integer $parentNodeId
	 */
	protected function preUpdate($document, $parentNodeId)
	{
		if (f_util_StringUtils::isNotEmpty($document->getNewItemLabel()))
		{
			$item = list_ItemService::getInstance()->getNewDocumentInstance();
			$item->setLabel($document->getNewItemLabel());
			$document->addItemdocuments($item);
			$document->setNewItemLabel(null);
		}
	}
}