<?php
/**
 * @package modules.list
 * @method list_ItemService getInstance()
 */
class list_ItemService extends f_persistentdocument_DocumentService
{
	/**
	 * @return list_persistentdocument_item
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_list/item');
	}

	/**
	 * Create a query based on 'modules_list/item' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_list/item');
	}

	/**
	 * @todo WTF? Deprecate?
	 * @return list_persistentdocument_item
	 */
	public function getItems()
	{
		
	}
	
	/**
	 * @param list_persistentdocument_item $document
	 * @param integer $parentNodeId Parent node ID where to save the document (optionnal).
	 * @return void
	 */
	protected function preInsert($document, $parentNodeId)
	{
		$list = list_EditablelistService::getInstance()->createQuery()
			->add(Restrictions::eq("id", $parentNodeId))
			->add(Restrictions::ieq("itemdocuments.label", $document->getLabel()))->findUnique();
		if ($list !== null)
		{
			throw new BaseException("Duplicate ".$document->getLabel()." list entry", "modules.list.bo.general.Error-duplicate-list-entry", array('label' => $document->getLabel()));
		}
	}
	
	/**
	 * @param list_persistentdocument_item $document
	 * @param integer $parentNodeId Parent node ID where to save the document (optionnal).
	 * @return void
	 */
	protected function preUpdate($document, $parentNodeId)
	{
		$listDocument = f_util_ArrayUtils::firstElement($document->getEditablelistArrayInverse());
		$query = list_EditablelistService::getInstance()->createQuery()->add(Restrictions::eq("id", $listDocument->getId()));
		$query->createCriteria("itemdocuments")
			->add(Restrictions::ieq("label", $document->getLabel()))
			->add(Restrictions::ne("id", $document->getId()));
		$list = $query->findUnique();
		if ($list !== null)
		{
			throw new BaseException("Duplicate ".$document->getLabel()." list entry", "modules.list.bo.general.Error-duplicate-list-entry", array('label' => $document->getLabel()));
		}
	}
	
	/**
	 * @param list_persistentdocument_item $document
	 */
	protected function preDelete($document)
	{
		if (($count = $this->countReferences($document)) > 1)
		{
			throw new IllegalOperationException('Document item cannot be deleted (' . ($count - 1) . ' usage)');
		}
	}
}