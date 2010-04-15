<?php
/**
 * @date Thu Mar 01 11:16:51 CET 2007
 * @author inthrycn
 */
class list_ItemService extends f_persistentdocument_DocumentService
{
	/**
	 * @var list_ItemService
	 */
	private static $instance;

	/**
	 * @return list_ItemService
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
		return $this->pp->createQuery('modules_list/item');
	}

	/**
	 *
	 * @return list_persistentdocument_item
	 */
	public function getItems()
	{
	    
	}
	
	/**
	 * (non-PHPdoc)
	 * @see persistentdocument/f_persistentdocument_DocumentService#preInsert($document, $parentNodeId)
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
	 * (non-PHPdoc)
	 * @see persistentdocument/f_persistentdocument_DocumentService#preUpdate($document, $parentNodeId)
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