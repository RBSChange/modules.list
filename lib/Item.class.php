<?php
class list_Item
{
	private $m_label;
	private $m_value;
	private $m_type;
	private $m_icon;

	public function __construct($label, $value, $type = null, $icon = null)
	{
		$this->m_label = $label;
		$this->m_value = $value;
		$this->m_type = $type;
		$this->m_icon = $icon;
	}

	public function setLabel($label)
	{
		$this->m_label = $label;
	}

	public function getLabel()
	{
		return $this->m_label;
	}

	public function setValue($value)
	{
		$this->m_value = $value;
	}

	public function getValue()
	{
		return $this->m_value;
	}

	public function setType($type)
	{
		$this->m_type = $type;
	}

	public function getType()
	{
		return $this->m_type;
	}

	public function setIcon($icon)
	{
		$this->m_icon = $icon;
	}

	public function getIcon()
	{
		return $this->m_icon;
	}
}

class list_StaticListItem extends list_Item
{
	private $labelKey;

	public function __construct($labelKey, $value)
	{
		$this->labelKey = $labelKey;
		$this->setValue($value);
	}

	public function setLabel($label)
	{
		throw new Exception("Can not set label on ".get_class($this));
	}

	public function getLabel()
	{
		return LocaleService::getInstance()->trans($this->labelKey, array('ucf'));
	}
}