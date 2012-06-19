<?php
/**
 * list_StaticlistUpdateScriptDocumentElement
 * @package modules.list.persistentdocument.import
 */
class list_StaticlistUpdateScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function initPersistentDocument()
	{
		$listid = $this->attributes['listid'];
		return list_ListService::getInstance()->getDocumentInstanceByListId($listid);
	}
	
	protected function saveDocument()
	{
	}
	
	public function endProcess()
	{
		$list = $this->getPersistentDocument();
		$children = $this->script->getChildren($this);
		
		$items = $list->getItems();
		if (count($children))
		{
			foreach ($children as $scriptElement)
			{
				if ($scriptElement instanceof list_StaticitemElement)
				{
					$newItem = $scriptElement->getStaticItem();
					$value = $newItem->getValue();
					$add = true;
					foreach ($items as $item)
					{
						if ($item->getValue() == $value)
						{
							if ($item->getLabel() == $newItem->getLabel())
							{
								$add = false;
								break;
							}
							throw new Exception('Item with value '.$value.' already exists with an other label!');
						}
					}					
					if ($add)
					{
						$items[] = $scriptElement->getStaticItem();
					}
				}
			}
		}
		
		$list->setItemvalues(serialize($items));
		if ($list->isModified())
		{
			$list->save();
		}
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_list/staticlist');
	}
}