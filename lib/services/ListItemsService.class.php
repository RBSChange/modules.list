<?php
/**
 * @date Tue Mar 06 15:31:43 CET 2007
 * @author inthrycn
 */
interface list_ListItemsService
{
	/**
	 * @return list_Item[]
	 */
	public function getItems();
	
	/**
	 * Optional.
	 * @param String $value
	 */
//	public function getItemByValue($value);
	
	/**
	 * Optional.
	 * @param Array $paramters
	 */
//	public function setParameters($paramters);
}