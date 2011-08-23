<?php
/**
 * list_ModuleService
 * @package modules.list.lib.services
 */
class list_ModuleService extends ModuleBaseService
{
	/**
	 * Singleton
	 * @var list_ModuleService
	 */
	private static $instance = null;

	/**
	 * @return list_ModuleService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * @param Integer $documentId
	 * @return f_persistentdocument_PersistentTreeNode
	 */
	public function getParentNodeForPermissions($documentId)
	{
		$document = DocumentHelper::getDocumentInstance($documentId);
		if ($document instanceof list_persistentdocument_item || $document instanceof list_persistentdocument_valueditem)
		{
			$query = list_EditablelistService::getInstance()->createQuery()
				->add(Restrictions::eq('itemdocuments.id', $document->getId()));
			$list = $query->findUnique();
			if ($list !== null)
			{
				return TreeService::getInstance()->getInstanceByDocumentId($list->getId());
			}
		}
		return null;
	}
}