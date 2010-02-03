<?php
/**
 * @author intsimoa
 * @package modules.list
 */
class list_ValuededitablelistService extends list_EditablelistService 
{
	/**
	 * @var list_ValuededitablelistService
	 */
	private static $instance;

	/**
	 * @return list_ValuededitablelistService
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
	 * @return list_persistentdocument_valuededitablelist
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_list/valuededitablelist');
	}

	/**
	 * Create a query based on 'modules_list/valuededitablelist' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_list/valuededitablelist');
	}
	
	/**
	 * @param list_persistentdocument_valuededitablelist $document
	 * @param Integer $parentNodeId
	 */
	protected function preUpdate($document, $parentNodeId)
	{
		if (f_util_StringUtils::isNotEmpty($document->getNewItemLabel()) &&
			f_util_StringUtils::isNotEmpty($document->getNewItemValue()))
		{
			$item = list_ValueditemService::getInstance()->getNewDocumentInstance();
			$item->setLabel($document->getNewItemLabel());
			$item->setValue($document->getNewItemValue());
			
			$document->addItemdocuments($item);
			$document->setNewItemLabel(null);
			$document->setNewItemValue(null);
		}
	}
}