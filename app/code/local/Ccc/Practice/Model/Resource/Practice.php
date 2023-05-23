<?php
class Ccc_Practice_Model_Resource_Practice extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('practice/practice', 'practice_id');
    }

    // public function __construct()
    // {
    //     $resource = Mage::getSingleton('core/resource');
    //     $this->setType('practice_entity');
    //     $this->setConnection(
    //         $resource->getConnection('practice_read'),
    //         $resource->getConnection('practice_write')
    //     );
    // }
    // protected function _getDefaultAttributes()
    // {
    //     return array(
    //         'entity_type_id',
    //         'attribute_set_id',
    //         'created_at',
    //         'updated_at',
    //         'increment_id',
    //         'store_id',
    //         'website_id'
    //     );
    // }
}
