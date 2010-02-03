<?php
class modules_list_tests_StaticlistService extends f_tests_AbstractBaseTest
{
	public function prepareTestCase()
	{
		RequestContext::clearInstance();
		RequestContext::getInstance()->setLang('fr');
		f_persistentdocument_PersistentProvider::getInstance()->reset();
	}

	private $list;
	private $service;

	public function preTestCreateArticlefamily()
	{
		// Create static list.
		$items = array(
			new list_StaticListItem('Label 1', 1),
			new list_StaticListItem('Label 2', 2),
			new list_StaticListItem('Label 4', 4),
			new list_StaticListItem('Label 135', 135),
			new list_StaticListItem('Label 44', 44),
			new list_StaticListItem('Label 2588', 2588),
			new list_StaticListItem('Label RBS', "rbs")
		);

		$this->service = list_StaticlistService::getInstance();
		$this->list = $this->service->getNewDocumentInstance();
		$this->list->setLabel('Test list');
		$this->list->setDescription('Test list');
		$this->list->setListid('modules_list/testlist1');
		$this->list->setItemvalues( serialize($items) );
		$this->list->save();
	}

	public function testCreateArticlefamily()
	{
		$this->assertEquals('Label 135', $this->service->getItemLabel($this->list, '135'));
		$this->assertEquals('Label RBS', $this->service->getItemLabel($this->list, 'rbs'));
	}

	public function postTestCreateArticlefamily()
	{
		$this->list->delete();
	}
}
