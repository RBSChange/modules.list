<?php
/**
 * @package modules.list
 * @method list_EditablelistService getInstance()
 */
class list_EditablelistService extends list_ListService
{
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
		return $this->getPersistentProvider()->createQuery('modules_list/editablelist');
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
	 * @param integer $parentNodeId
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