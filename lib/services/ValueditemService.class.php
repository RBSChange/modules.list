<?php
/**
 * @package modules.list
 * @method list_ValueditemService getInstance()
 */
class list_ValueditemService extends f_persistentdocument_DocumentService
{
	/**
	 * @return list_persistentdocument_valueditem
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_list/valueditem');
	}

	/**
	 * Create a query based on 'modules_list/valueditem' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_list/valueditem');
	}
	
	/**
	 * @param string $forModuleName
	 * @param array $allowedSections
	 * @return array
	 */
	public function getResume($document, $forModuleName, $allowedSections = null)
	{
		$resume = parent::getResume($document, $forModuleName, $allowedSections);
		$resume["properties"]["value"] = $document->getValue();
		return $resume;
	}
	
	/**
	 * @param list_persistentdocument_valueditem $document
	 * @param integer $parentNodeId Parent node ID where to save the document (optionnal).
	 * @return void
	 */
	protected function preInsert($document, $parentNodeId)
	{
		$list = list_ValuededitablelistService::getInstance()->createQuery()
			->add(Restrictions::eq("id", $parentNodeId))
			->add(Restrictions::ieq("itemdocuments.label", $document->getLabel()))->findUnique();
		if ($list !== null)
		{
			throw new BaseException("Duplicate ".$document->getLabel()." list entry", "modules.list.bo.general.Error-duplicate-list-entry", array('label' => $document->getLabel()));
		}
		
		$list = list_ValuededitablelistService::getInstance()->createQuery()
			->add(Restrictions::eq("id", $parentNodeId))
			->add(Restrictions::eq("itemdocuments.value", $document->getValue()))->findUnique();
		if ($list !== null)
		{
			throw new BaseException("Duplicate ".$document->getValue()." list value entry", "modules.list.bo.general.Error-duplicate-list-value-entry", array('value' => $document->getValue()));
		}
	}
	
	/**
	 * @param list_persistentdocument_valueditem $document
	 * @param integer $parentNodeId Parent node ID where to save the document (optionnal).
	 * @return void
	 */
	protected function preUpdate($document, $parentNodeId)
	{
		$listDocument = f_util_ArrayUtils::firstElement($document->getValuededitablelistArrayInverse());
		
		$query = list_ValuededitablelistService::getInstance()->createQuery()->add(Restrictions::eq("id", $listDocument->getId()));
		$query->createCriteria("itemdocuments")
			->add(Restrictions::ieq("label", $document->getLabel()))
			->add(Restrictions::ne("id", $document->getId()));
		$list = $query->findUnique();
		if ($list !== null)
		{
			throw new BaseException("Duplicate ".$document->getLabel()." list entry", "modules.list.bo.general.Error-duplicate-list-entry", array('label' => $document->getLabel()));
		}
		
		$query = list_ValuededitablelistService::getInstance()->createQuery()->add(Restrictions::eq("id", $listDocument->getId()));
		$query->createCriteria("itemdocuments")
			->add(Restrictions::eq("value", $document->getValue()))
			->add(Restrictions::ne("id", $document->getId()));
		$list = $query->findUnique();
		if ($list !== null)
		{
			throw new BaseException("Duplicate ".$document->getValue()." list value entry", "modules.list.bo.general.Error-duplicate-list-value-entry", array('value' => $document->getValue()));
		}
	}
}