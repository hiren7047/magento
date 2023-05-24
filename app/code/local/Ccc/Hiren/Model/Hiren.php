<?php
class Ccc_Hiren_Model_Hiren extends Mage_Core_Model_Abstract
{
	protected $_attributes;
	const ENTITY = 'hiren';

	public function _construct()
	{
		parent::_construct();
        $this->_init('hiren/hiren');
	}

    public function checkInGroup($attributeId, $setId, $groupId)
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $query = ' SELECT * FROM ' . $resource->getTableName('eav/entity_attribute')
            . ' WHERE `attribute_id` =' . $attributeId
            . ' AND `attribute_group_id` =' . $groupId
            . ' AND `attribute_set_id` =' . $setId ;

        $results = $readConnection->fetchRow($query);
        if ($results) {
            return true;
        }
        return false;
    }
}