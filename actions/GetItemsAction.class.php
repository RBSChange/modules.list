<?php
class list_GetItemsAction extends f_action_BaseAction
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
		try 
		{
			$rc->beginI18nWork($rc->getUILang());		
			$ls = $this->getListService();
	
			try
			{
				$list = $ls->getDocumentInstanceByListId($listName);
			}
			catch (BaseException $e)
			{
				Framework::exception($e);	
				// The list has not been found: switch to error view
				$request->setAttribute('message', $e->getMessage());
				return View::ERROR;
			}
			
			$request->setAttribute('items', $list->getItems());
			$rc->endI18nWork();
		}
		catch (Exception $e)
		{
			$request->setAttribute('items', array());
			$rc->endI18nWork($e);
			Framework::exception($e);
		}

		return View::SUCCESS;
	}

	/**
	 * @return list_ListService
	 */
	public function getListService()
	{
		return list_ListService::getInstance();
	}

	public function getRequestMethods()
	{
		return Request::POST | Request::GET;
	}
}