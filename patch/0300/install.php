<?php
/**
 * list_patch_0300
 * @package modules.list
 */
class list_patch_0300 extends patch_BasePatch
{
	/**
	 * Entry point of the patch execution.
	 */
	public function execute()
	{
		/*$newPath = f_util_FileUtils::buildWebeditPath('modules/list/persistentdocument/editablelist.xml');
		$newModel = generator_PersistentModel::loadModelFromString(f_util_FileUtils::read($newPath), 'list', 'editablelist');
		$newProp = $newModel->getPropertyByName('useVoIfNotTranslated');
		f_persistentdocument_PersistentProvider::getInstance()->addProperty('list', 'editablelist', $newProp);*/
	
		foreach (list_EditablelistService::getInstance()->createQuery()->find() as $list)
		{
			$list->setUseVoIfNotTranslated(true);
			$list->save();
		}
	}
	
	/**
	 * @return String
	 */
	protected final function getModuleName()
	{
		return 'list';
	}
	
	/**
	 * @return String
	 */
	protected final function getNumber()
	{
		return '0300';
	}
}