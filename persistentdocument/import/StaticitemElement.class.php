<?php
/**
 * list_StaticitemElement
 * @package modules.list.persistentdocument.import
 */
class list_StaticitemElement extends  import_ScriptBaseElement
{
    public function getStaticItem()
    {
        return new list_StaticListItem($this->attributes['label'], $this->attributes['value']);
    }
}