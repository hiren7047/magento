<?php
class Ccc_Practice_Adminhtml_QueryController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "<pre>";
        // $resource = Mage::getSingleton('core/resource');
        // $write = $resource->getConnection('core_write');
        // $table = $resource->getTableName('product/product');
        // $table2 = $resource->getTableName('idx/idx');

        // $write->insert(
        //     $table, 
        //     ['sku' => 'ABCD', 'cost' => 200]
        // );

        // echo $select = $write->select()
        //     ->from(['tbl' => $table], ['product_id', 'sku'])
        //     ->joinLeft(['tbl2' => $table2], 'tbl.product_id = tbl2.product_id', ['sku']);   
            // ->group('cost')
            // ->where('name LIKE ?', "%{$name}%")
        // $results = $write->fetchAll($select);

        // $write->update(
        //     $table,
        //     ['sku' => 'ABCSD', 'cost' => 5000],
        //     ['product_id = ?' => 12]
        // );


        //Delete:

        // $write->delete(
        //     $table,
        //     ['product_id IN (?)' => [25, 32]]
        // );


        //Insert Multiple:

        // $rows = [
        //     ['sku'=>'value1', 'cost'=>'value2', 'price'=>'value3'],
        //     ['sku'=>'value3', 'cost'=>'value4', 'price'=>'value5'],
        // ];
        // $write->insertMultiple($table, $rows);


        //Insert Update On Duplicate:

        // $data = [];
        // $data[] = [
        //     'sku' => 'BGSDGH',
        //     'cost' => 50000
        // ];

        // $write->insertOnDuplicate(
        //     $table,
        //     $data, // Could also be an array of rows like insertMultiple
        //     ['cost'] // this is the fields that will be updated in case of duplication
        // );

        die;
    }
}
