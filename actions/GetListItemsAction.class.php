<?php
class list_GetListItemsAction extends f_action_BaseJSONAction
{
    /**
     * @param Context $context
     * @param Request $request
     */
	public function _execute($context, $request)
	{
		// Retrieve request data
		$listName = $request->getParameter(K::COMPONENT_ID_ACCESSOR);
		$rc = RequestContext::getInstance();
		$result = array();
		
		try 
		{
			$rc->beginI18nWork($rc->getUILang());		
			try
			{
				$ls = list_ListService::getInstance();
				$list = $ls->getDocumentInstanceByListId($listName);
				$list->setParameters($request->getParameters());
				foreach ($list->getItems() as $item) 
				{
					$itemArray = array('id' => $item->getValue(), 'label' => $item->getLabel());
					if ($item->getType())
					{
						$itemArray['type'] = $item->getType();
					}
					if ($item->getIcon())
					{
					   $itemArray['icon'] =  $item->getIcon();
					}				
					
					$result[] = $itemArray;
				}
				
				
			}
			catch (ListNotFoundException $e)
			{
				Framework::exception($e);	
			}
			$rc->endI18nWork();
		}
		catch (Exception $e)
		{
			$rc->endI18nWork($e);
		}

		return $this->sendJSON($result);
	}

	public function getRequestMethods()
	{
		return Request::POST | Request::GET;
	}
}