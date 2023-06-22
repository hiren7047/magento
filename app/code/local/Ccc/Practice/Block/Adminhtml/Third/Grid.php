<?php

class Ccc_Practice_Block_Adminhtml_Third_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('thirdGrid');
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
                    $optionCount = 0;
                    foreach ($options as $option) {
                        $optionCount += 1;
                    }
                    $data[] = array(
                        'attribute_id'=>$attribute->getId(),
                        'attribute_code'=>$attribute->getAttributeCode(),
                        'option_count'=>$optionCount,
                    );
                } else {
                    $query = $readConnection->select()
                        ->from(array('ao' => $optionsTable), array('option_id', 'sort_order'))
                        ->joinLeft(array('aov' => $optionsValueTable), 'aov.option_id = ao.option_id', array('value'))
                        ->where('ao.attribute_id = ?', $attribute->getId())
                        ->order('ao.sort_order ASC');
                    $options = $readConnection->fetchAll($query);
                    $optionCount = 0;
                    foreach ($options as $option) {
                        $optionCount += 1;
                    }
                    $data[] = array(
                        'attribute_id'=>$attribute->getId(),
                        'attribute_code'=>$attribute->getAttributeCode(),
                        'option_count'=>$optionCount,
                    );
                }
        }

        $collection = new Varien_Data_Collection();

        foreach ($data as $value) {
            if($value['option_count']>=2){
                $item = new Varien_Object($value);
                $collection->addItem($item);
            }
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();

        die;
        // $collection = Mage::getModel('eav/entity_attribute')->getCollection();

        // $collection->getSelect()->joinLeft(
        //     array('option_count_table' => $collection->getTable('eav/attribute_option')),
        //     'option_count_table.attribute_id = main_table.attribute_id',
        //     array('option_count' => 'COUNT(option_count_table.option_id)')
        // );

        // $collection->getSelect()->group('main_table.attribute_id');
        // $collection->getSelect()->having('COUNT(option_count_table.option_id) > 1', 1);

        // $this->setCollection($collection);
        // return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('attribute_id', array( 
            'header'    => Mage::helper('practice')->__('Attribute Id'),
            'align'     => 'left',
            'index'     => 'attribute_id',
        ));

        $this->addColumn('attribute_code', array( 
            'header'    => Mage::helper('practice')->__('Code'),
            'align'     => 'left',
            'index'     => 'attribute_code',
        ));

        $this->addColumn('option_count', array( 
            'header'    => Mage::helper('practice')->__('Option Count'),
            'align'     => 'left',
            'index'     => 'option_count',
        ));

        return parent::_prepareColumns();
    }
}