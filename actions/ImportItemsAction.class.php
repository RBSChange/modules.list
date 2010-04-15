<?php
class list_ImportItemsAction extends f_action_BaseJSONAction
{
	/**
	 * @param Context $context
	 * @param Request $request
	 * @return unknown
	 */
	public function _execute($context, $request)
	{
		if (!count($_FILES))
		{
			return $this->sendJSONError(f_Locale::translateUI('&modules.list.bo.general.Import-error;'));
		}
		
		if ($_FILES['filename']['error'] != UPLOAD_ERR_OK)
		{
			return $this->sendJSONError(f_Locale::translateUI('&modules.list.bo.general.Import-error;'));
		}
		
		$filePath = $_FILES['filename']['tmp_name'];
		$handle = fopen($filePath, "r");
		
		$warnings = array();
		$rows = array();
		$lineCount = -1;
		while (($data = fgetcsv($handle, 5000, ";", "\"")) !== FALSE)
		{
			$lineCount++;
			if ($lineCount == 0)
			{
				// Skip the first line.
				continue;
			}
			if (count($data) < 1)
			{
				$warnings[] = array(f_Locale::translateUI('&modules.list.bo.general.Line-ignored;', array('linecCount' => $lineCount)));
				continue;
			}
			$rows[] = $data;
		}
		
		$tm = f_persistentdocument_TransactionManager::getInstance();		
		$mode = $request->getParameter('mode', 'complete');
		$labels = array();
		$list = $this->getDocumentInstanceFromRequest($request);
		if ($list instanceof list_persistentdocument_valuededitablelist)
		{
			try 
			{
				$tm->beginTransaction();
				$is = list_ValueditemService::getInstance();
				foreach ($rows as $row)
				{
					$label = mb_convert_encoding($row[0], 'UTF-8', 'CP1252');
					$value = mb_convert_encoding($row[1], 'UTF-8', 'CP1252');
					$item = $is->createQuery()->add(Restrictions::eq('value', $value))->add(Restrictions::eq('valuededitablelist', $list))->findUnique();
					if ($item === null)
					{
						$item = $is->createQuery()->add(Restrictions::eq('label', $label))->add(Restrictions::isEmpty('value'))->add(Restrictions::eq('valuededitablelist', $list))->findUnique();
					}
					if ($item === null)
					{
						$item = $is->getNewDocumentInstance();
					}
					$item->setLabel($label);
					$item->setValue($value);
					$item->save($list->getId());
					$labels[] = $label; 
				}
				if ($mode === 'replace')
				{
					$is->createQuery()->add(Restrictions::notIn('label', $labels))->add(Restrictions::eq('valuededitablelist', $list))->delete();
				}
				$tm->commit();
			}
			catch (Exception $e)
			{
				$tm->rollBack($e);
				return $this->sendJSONErrorForException($e);
			}
		}
		else if ($list instanceof list_persistentdocument_editablelist)
		{
			try 
			{
				$tm->beginTransaction();
				$is = list_ItemService::getInstance();
				foreach ($rows as $row)
				{
					$label = mb_convert_encoding($row[0], 'UTF-8', 'CP1252');
					$item = $is->createQuery()->add(Restrictions::eq('label', $label))->add(Restrictions::eq('editablelist', $list))->findUnique();
					if ($item === null)
					{
						$item = $is->getNewDocumentInstance();
						$item->setLabel($label);
						$item->save($list->getId());
					}
					$labels[] = $label; 
				}
				if ($mode === 'replace')
				{
					$is->createQuery()->add(Restrictions::notIn('label', $labels))->add(Restrictions::eq('editablelist', $list))->delete();
				}
				$tm->commit();
			}
			catch (Exception $e)
			{
				$tm->rollBack($e);
				return $this->sendJSONErrorForException($e);
			}
		}
		else
		{
			return $this->sendJSONError(f_Locale::translateUI('&modules.list.bo.general.Invalid-list;'));
		}
		
		return $this->sendJSON(array('warnings' => $warnings));
	}
	
	/**
	 * @param Exception $e
	 */
	private function sendJSONErrorForException($e)
	{
		while ($e instanceof TransactionCancelledException)
		{
			$e = $e->getSourceException();	
		}
		if ($e instanceof BaseException)
		{
			return $this->sendJSONError(f_Locale::translateUI('&modules.list.bo.general.Error-importing-list;', array('exception' => f_Locale::translateUI($e->getLocaleMessage()))));
		}
		else
		{
			return $this->sendJSONError(f_Locale::translateUI('&modules.list.bo.general.Error-importing-list;', array('exception' => $e->getMessage())));
		}
	}
}