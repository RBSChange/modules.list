<?php
/**
 * @package modules.list
 * @method list_ModuleService getInstance()
 */
class list_ModuleService extends ModuleBaseService
{
	/**
	 * @param integer $documentId
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