<?php

class Ccc_Practice_QueryController extends Mage_Adminhtml_Controller_Action
{

    public function firstAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_first'));
        $this->renderLayout();
    }

    public function firstQueryAction()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array(
                'sku' => 'e.sku',
                'name' => 'ov.value',
                'price' => 'a.value',
                'cost' => 'b.value',
                'color' => 'c.value',
            ))
            ->joinLeft(
                array('ov' => 'catalog_product_entity_varchar'),
                    'ov.entity_id = e.entity_id AND ov.attribute_id = 73',
                    array()
            )
            ->joinLeft(
                array('a' => 'catalog_product_entity_decimal'),
                'a.entity_id = e.entity_id AND a.attribute_id = 77',
                array()
            )
            ->joinLeft(
                array('b' => 'catalog_product_entity_decimal'),
                'b.entity_id = e.entity_id AND b.attribute_id = 81',
                array()
            )
            ->joinLeft(
                array('c' => 'catalog_product_entity_int'),
                'c.entity_id = e.entity_id AND c.attribute_id = 94',
                array()
            );

        echo $collection->getSelect()."<br><br>";

        // die;

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $tableName = $resource->getTableName('catalog/product');
        $select = $readConnection->select()
            ->from(array('p' => $tableName), array(
                'sku' => 'p.sku',
                'name' => 'ov.value',
                'price' => 'a.value',
                'cost' => 'b.value',
                'color' => 'c.value',
            ))
            ->joinLeft(
                array('ov' => $resource->getTableName('catalog_product_entity_varchar')),
                'ov.entity_id = p.entity_id AND ov.attribute_id = 73',
                array()
            )
            ->joinLeft(
                array('a' => $resource->getTableName('catalog_product_entity_decimal')),
                'a.entity_id = p.entity_id AND a.attribute_id = 77',
                array()
            )
            ->joinLeft(
                array('b' => $resource->getTableName('catalog_product_entity_decimal')),
                'b.entity_id = p.entity_id AND b.attribute_id = 81',
                array()
            )
            ->joinLeft(
                array('c' => $resource->getTableName('catalog_product_entity_int')),
                'c.entity_id = p.entity_id AND c.attribute_id = 94',
                array()
            );

        echo $select;die;
    }

    public function secondAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_second'));
        $this->renderLayout();
    }

    public function secondQueryAction()
    {
        $attributeOptions = [];

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $attributeOptionTable = $resource->getTableName('eav_attribute_option');
        $attributeTable = $resource->getTableName('eav_attribute');

        $select = $readConnection->select()
            ->from(
                array('ao' => $attributeOptionTable),
                array(
                    'attribute_id' => 'ao.attribute_id',
                    'option_id' => 'ao.option_id',
                    'option_name' => 'ov.value',
                )
            )
            ->join(
                array('ov' => $resource->getTableName('eav_attribute_option_value')),
                'ov.option_id = ao.option_id',
                array()
            )
            ->join(
                array('a' => $attributeTable),
                'a.attribute_id = ao.attribute_id',
                array('attribute_code' => 'a.attribute_code')
            );

        echo $select;die;
    }

    public function thirdAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_third'));
        $this->renderLayout();
    }

    public function thirdQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $attributeOptionTable = $resource->getTableName('eav_attribute_option');
        $attributeTable = $resource->getTableName('eav_attribute');

        $select = $readConnection->select()
            ->from(
                array('main_table' => $attributeTable),
                array(
                    'attribute_id' => 'main_table.attribute_id',
                    'attribute_code' => 'main_table.attribute_code',
                )
            )
            ->joinLeft(
                array('option_count_table' => $attributeOptionTable),
                'option_count_table.attribute_id = main_table.attribute_id',
                array(
                    'option_count' => new Zend_Db_Expr('COUNT(option_count_table.option_id)'),
                    // 'option_count' => 'COUNT(option_count_table.option_id)',
                )
            )
            ->group('main_table.attribute_id')
            ->having('COUNT(option_count_table.option_id) > 10', 1);

        echo '<br><br>'.$select;die;
    }

    public function forthAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_forth'));
        $this->renderLayout();
    }

    public function forthQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        echo $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('vc'=>$resource->getTableName('catalog_product_entity_varchar')),
                'vc.entity_id = main_table.entity_id AND vc.attribute_id = 87',
                array('image' => 'vc.value')
            )
            ->joinLeft(
                array('thumb'=>$resource->getTableName('catalog_product_entity_varchar')),
                'thumb.entity_id = main_table.entity_id AND thumb.attribute_id = 89',
                array('thumbnail' => 'thumb.value')
            )
            ->joinLeft(
                array('small'=>$resource->getTableName('catalog_product_entity_varchar')),
                'small.entity_id = main_table.entity_id AND small.attribute_id = 88',
                array('small' => 'small.value')
            );
    }

    public function fifthAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_fifth'));
        $this->renderLayout();
    }

    public function fifthQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        echo $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('m'=>$resource->getTableName('catalog/product_attribute_media_gallery')),
                'm.entity_id = main_table.entity_id',
                array('image' => 'COUNT(m.value)')
            )
            ->group('main_table.entity_id');
    }

    public function sixthAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_sixth'));
        $this->renderLayout();
    }

    public function sixthQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        echo $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('customer_entity')),
                array('entity_id','email')
            )
            ->joinLeft(
                array('e'=>$resource->getTableName('customer_entity_varchar')),
                'e.entity_id = main_table.entity_id AND e.attribute_id = 5',
                array('firstname' => 'e.value')
            )
            ->joinLeft(
                array('o' => $resource->getTableName('sales/order')),
                'o.customer_id = e.entity_id',
                array('order_count' => 'COUNT(o.entity_id)')
            )
            ->group('main_table.entity_id');
    }

    public function sevenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_seven'));
        $this->renderLayout();
    }

    public function sevenQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        echo $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('customer_entity')),
                array('entity_id','email')
            )
            ->joinLeft(
                array('e'=>$resource->getTableName('customer_entity_varchar')),
                'e.entity_id = main_table.entity_id AND e.attribute_id = 5',
                array('firstname' => 'e.value')
            )
            ->joinLeft(
                array('o' => $resource->getTableName('sales/order')),
                'o.customer_id = e.entity_id',
                array('order_count' => 'COUNT(o.entity_id)')
            )
            ->joinLeft(
                array('s' => Mage::getSingleton('core/resource')->getTableName('sales_order_status')),
                'o.status = s.status',
                array('order_status' => 's.label')
            )
            ->group('main_table.entity_id');
    }

    public function eightAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_eight'));
        $this->renderLayout();
    }

    public function eightQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        // echo $select = $resource->getConnection('core_read')
        //     ->select()
        //     ->from(array('e' => $resource->getTableName('catalog/product')),array('entity_id','sku'))
        //     ->joinLeft(
        //         array('oi' => $resource->getTableName('sales/order_item')),
        //         'e.entity_id = oi.product_id',
        //         array('sold_quantity' => 'SUM(oi.qty_ordered)')
        //     )
        //     ->group('e.entity_id');


        echo $select = $readConnection->select()
            ->from(
                array('oi' => $resource->getTableName('sales/order_item')), 
                array('product_id','sku','SUM(qty_ordered)')
            )
            // ->columns(array(
            //     'product_id' => 'oi.product_id',
            //     'sku' => 'oi.sku',
            //     'sold_quantity' => new Zend_Db_Expr('SUM(oi.qty_ordered)')
            // ))
            ->group('oi.product_id');
    }

    public function nineAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_nine'));
        $this->renderLayout();
    }

    public function nineQueryAction()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        echo "<pre>";
        echo $select = $connection->select()
        ->from(
            array('e' => 'catalog_product_entity'),
            array('entity_id AS product_id','sku')
        )
        ->join(
            array('a' => 'eav_attribute'),
            'e.entity_type_id = a.entity_type_id',
            array('attribute_id', 'attribute_code')
        )
        ->joinLeft(
            array('avc' => 'catalog_product_entity_varchar'),
            'e.entity_id = avc.entity_id AND avc.attribute_id = a.attribute_id',
            array()
        )
        ->joinLeft(
            array('avi' => 'catalog_product_entity_int'),
            'e.entity_id = avi.entity_id AND avi.attribute_id = a.attribute_id',
            array()
        )
        ->joinLeft(
            array('avd' => 'catalog_product_entity_decimal'),
            'e.entity_id = avd.entity_id AND avd.attribute_id = a.attribute_id',
            array()
        )
        ->joinLeft(
            array('avt' => 'catalog_product_entity_text'),
            'e.entity_id = avt.entity_id AND avt.attribute_id = a.attribute_id',
            array()
        )
        ->where('avc.value IS NULL AND avi.value IS NULL AND avd.value IS NULL AND avt.value IS NULL')
        ->where('a.is_user_defined = ?', 1);
    }

    public function tenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_ten'));
        $this->renderLayout();
    }

    public function tenQueryAction()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $tablePrefix = Mage::getConfig()->getTablePrefix();

        echo $select = $connection->select()
        ->from(
            array('e' => 'catalog_product_entity'),
            array('entity_id AS product_id','sku')
        )
        ->join(
            array('a' => 'eav_attribute'),
            'e.entity_type_id = a.entity_type_id',
            array('attribute_id', 'attribute_code')
        )
        ->joinLeft(
            array('avc' => 'catalog_product_entity_varchar'),
            'e.entity_id = avc.entity_id AND avc.attribute_id = a.attribute_id',
            array()
        )
        ->joinLeft(
            array('avi' => 'catalog_product_entity_int'),
            'e.entity_id = avi.entity_id AND avi.attribute_id = a.attribute_id',
            array('avi.value')
        )
        ->joinLeft(
            array('avd' => 'catalog_product_entity_decimal'),
            'e.entity_id = avd.entity_id AND avd.attribute_id = a.attribute_id',
            array()
        )
        ->joinLeft(
            array('avt' => 'catalog_product_entity_text'),
            'e.entity_id = avt.entity_id AND avt.attribute_id = a.attribute_id',
            array()
        )
        ->where('avc.value IS NOT NULL OR avi.value IS NOT NULL OR avd.value IS NOT NULL OR avt.value IS NOT NULL')
        ->where('a.is_user_defined = ?', 1);
    }

    public function csvAction()
    {
        echo "string";
    }

    public function testAction()
    {
        echo "<pre>";
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        // echo "<pre>"; print_r($connection);die;
        echo $select = $connection->select()->
        from(
            array('e' =>'catalog_product_entity'),
            array(
                'entity_id',
                'eo.value',
                'sku'

                // 'attribute_code',
                // 'eo.option_count' => new Zend_Db_Expr('COUNT(eo.option_id)'),
            )
        )
        ->joinLeft(
            array('eo'=>'catalog_product_entity_varchar'),
            'e.entity_id = eo.entity_id',
            array()
        )
        ->where('attribute_id = 87 OR attribute_id = 88 OR attribute_id = 89')
        ;
        die;
    }

}
