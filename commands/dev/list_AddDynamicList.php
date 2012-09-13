<?php
/**
 * commands_list_AddDynamicList
 * @package modules.list.command
 */
class commands_list_AddDynamicList extends c_ChangescriptCommand
{
	/**
	 * @return string
	 */
	function getUsage()
	{
		return "<moduleName> <listShortName>";
	}

	/**
	 * @return string
	 */
	function getDescription()
	{
		return "adds a new dynamic list with listId = \"modules_<moduleName>/<listShortName>\"";
	}

	/**
	 * This method is used to handle auto-completion for this command.
	 * @param integer $completeParamCount the parameters that are already complete in the command line
	 * @param string[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @return string[] or null
	 */
	function getParameters($completeParamCount, $params, $options, $current)
	{
		$components = array();
		
		if ($completeParamCount == 0)
		{
			foreach (glob("modules/*", GLOB_ONLYDIR) as $module)
			{
				$components[] = basename($module);
			}
			return $components;
		}
				
		return array_diff($components, $params);
	}
	
	/**
	 * @param string[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 */
	protected function validateArgs($params, $options)
	{
		return (count($params) == 2);
	}

	/**
	 * @param string[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @see c_ChangescriptCommand::parseArgs($args)
	 */
	function _execute($params, $options)
	{
		$this->message("== AddDynamicList ==");

		$this->loadFramework();
		
		$moduleName = strtolower($params[0]);
		$listShortName = strtolower($params[1]);
		$listShortNameUcf = ucfirst($listShortName);
				
		if (!ModuleService::getInstance()->moduleExists($moduleName))
		{
			return $this->quitError("Module $moduleName does not exits");
		}
		
		$servicesFolder = f_util_FileUtils::buildProjectPath('modules', $moduleName, 'lib', 'services');
		$serviceFile = $servicesFolder . DIRECTORY_SEPARATOR . 'List' . $listShortNameUcf . 'Service.php';
		$serviceClass = $moduleName . '_List' . $listShortNameUcf . 'Service';
		$listId = 'modules_' . $moduleName . '/' . $listShortName;
		
		if (file_exists($serviceFile))
		{
			return $this->quitError('The list "' . $listId . '" already exists in ' . $moduleName . '".');
		}
		
		$generator = new builder_Generator();
		$generator->setTemplateDir(f_util_FileUtils::buildProjectPath('modules', 'list', 'templates', 'builder'));
		$generator->assign('author', $this->getAuthor());
		$generator->assign('shortName', $listShortName);
		$generator->assign('listId', $listId);
		$generator->assign('module', $moduleName);
		$generator->assign('date', date('r'));
		$generator->assign('class', $serviceClass);
		$result = $generator->fetch('dynamiclistService.tpl');
		
		f_util_FileUtils::mkdir($servicesFolder);
		f_util_FileUtils::write($serviceFile, $result);

		change_AutoloadBuilder::getInstance()->appendFile($serviceFile);
		$this->message('Service class path: ' . $serviceFile);
		
		// Add locale.
		$baseKey = strtolower('m.' . $moduleName . '.list');
		$keysInfos = array('fr_FR' => array($listShortName . '-label' => $listShortName . '-label'));
		LocaleService::getInstance()->updatePackage($baseKey, $keysInfos, false, true, '');
		$keysInfos = array('fr_FR' => array($listShortName . '-description' => $listShortName . '-description'));
		LocaleService::getInstance()->updatePackage($baseKey, $keysInfos, false, true, '');
		$this->message('List locales in ' . $baseKey . ': ' . $listShortName . '-label' . ' and ' . $listShortName  . '-description');

		// Generate the import script.
		$setupFolder = f_util_FileUtils::buildProjectPath('modules', $moduleName, 'setup');
		$scriptFile = $setupFolder . DIRECTORY_SEPARATOR . 'list-' . $listShortName . '.xml';
		if (file_exists($scriptFile))
		{
			$this->warnMessage('The file "' . $scriptFile . '" already exists, XML code for import not generated.');
		}
		else 
		{
			$generator->assign('shortNameUcf', $listShortNameUcf);
			$result = $generator->fetch('listXmlImport.tpl');
			f_util_FileUtils::mkdir($setupFolder);
			f_util_FileUtils::write($scriptFile, $result);
			$this->message('XML code to import this list: ' . $scriptFile);
		}
		
		$this->quitOk("Command successfully executed");
	}
}