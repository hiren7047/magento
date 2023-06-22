<?php

class Ccc_Practice_Block_Adminhtml_Second_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('practiceAdminhtmlPracticeGrid');
        $this->setDefaultSort('name');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $attributes = Mage::getModel('eav/entity_attribute')->getCollection();
        $attributes->addFieldToFilter('is_user_defined', 1 );
        $attributes->addFieldToFilter('frontend_input', array('select','multiselect') );
        $readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $optionsTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option');
        $optionsValueTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value');

        foreach ($attributes as $attribute) {
            if ($attribute->getSourceModel()) {
                $options = $attribute->getSource()->getAllOptions(false);
                foreach ($options as $option) {
                    $allOptions[] = array(
                        'attribute_id'=>$attribute->getId(),
                        'attribute_code'=>$attribute->getAttributeCode(),
                        'option_id'=>$option['value'],
                        'option_name'=>$option['label'],
                    );
                }
            } else {
                $query = $readConnection->select()
                    ->from(array('o' => $optionsTable), array('option_id', 'sort_order'))
                    ->joinLeft(array('ov' => $optionsValueTable), 'ov.option_id = o.option_id', array('value'))
                    ->where('o.attribute_id = ?', $attribute->getId())
                    ->order('o.sort_order ASC');
                $options = $readConnection->fetchAll($query);
                foreach ($options as $option) {
                    $allOptions[] = array(
                        'attribute_id'=>$attribute->getId(),
                        'attribute_code'=>$attribute->getAttributeCode(),
                        'option_id'=>$option['option_id'],
                        'option_name'=>$option['value'],
                    );
                }
            }
        }


        $collection = new Varien_Data_Collection();

        foreach ($allOptions as $data) {
            $item = new Varien_Object($data);
            $collection->addItem($item);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('attribute_id', array(
            'header'    => Mage::helper('practice')->__('Attribute ID'),
            'align'     => 'left',
            'index'     => 'attribute_id'
        ));

        $this->addColumn('attribute_code', array(
            'header'    => Mage::helper('practice')->__('Attribute Code'),
            'align'     => 'left',
            'index'     => 'attribute_code'
        ));

        $this->addColumn('option_id', array(
            'header'    => Mage::helper('practice')->__('Option ID'),
            'align'     => 'left',
            'index'     => 'option_id'
        ));

        $this->addColumn('option_name', array(
            'header'    => Mage::helper('practice')->__('Option Name'),
            'align'     => 'left',
            'index'     => 'option_name'
        ));

        return parent::_prepareColumns();
    }
}