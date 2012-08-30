<?php
/**
 * @package modules.list
 */
interface list_ListItemsService
{
	/**
	 * @return list_Item[]
	 */
	public function getItems();
	
	// /!\ Please do not remove these comments.
	
	/**
	 * Optional.
	 * @param string $value
	 */
//	public function getItemByValue($value);
	
	/**
	 * Optional.
	 * @param Array $paramters
	 */
//	public function setParameters($paramters);
}