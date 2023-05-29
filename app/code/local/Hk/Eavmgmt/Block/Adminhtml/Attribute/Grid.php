<?php
class Hk_Eavmgmt_Block_Adminhtml_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

  protected function _prepareCollection()
    {
        // $collection = Mage::getResourceModel('eavmgmt/attribute_collection');
        $collection = Mage::getResourceModel('eav/entity_attribute_collection');
        // echo "<pre>";
        // die;
        // print_r($collection->getData());

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->addColumn('entity_type_id', array(
            'header'=>Mage::helper('eav')->__('Entity Type'),
            'sortable'=>true,
            'index'=>'entity_type_id',
            'renderer'=>'Hk_Eavmgmt_Block_Adminhtml_Attribute_Csv_EntityType'
        ));

        $this->addColumn('attribute_id', array(
            'header'    => Mage::helper('eav')->__('Attribute Id'),
            'align'     => 'left',
            'index'     => 'attribute_id'
        ));

        $this->addColumn('attribute_code', array(
            'header'    => Mage::helper('eav')->__('Attribute Code'),
            'align'     => 'left',
            'index'     => 'attribute_code'
        ));

        $this->addColumn('frontend_label', array(
            'header'    => Mage::helper('eav')->__('Attribute Name'),
            'align'     => 'left',
            'index'     => 'frontend_label'
        ));

        $this->addColumn('frontend_input', array(
            'header'    => Mage::helper('eav')->__('Input Type'),
            'align'     => 'left',
            'index'     => 'frontend_input'
        ));

        $this->addColumn('backend_type', array(
            'header'    => Mage::helper('eav')->__('Backend Type'),
            'align'     => 'left',
            'index'     => 'backend_type'
        ));

        $this->addColumn('source_model', array(
            'header'    => Mage::helper('eav')->__('Source Model'),
            'align'     => 'left',
            'index'     => 'source_model'
        ));

       $this->addColumn('showOption', array(
                'header'    => Mage::helper('eav')->__('Show Option'),
                'align'     => 'left',
                'renderer'  => 'Hk_Eavmgmt_Block_Adminhtml_Attribute_Csv_Renderer_OptionLink'
            ));
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        return $this;
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('attribute_id');
        $this->getMassactionBlock()->setFormFieldName('eavmgmt');

        $this->getMassactionBlock()->addItem('export', array(
             'label'    => Mage::helper('eavmgmt')->__('Export'),
             'url'      => $this->getUrl('*/*/massExport'),
        ));
         $this->getMassactionBlock()->addItem('exportOption', array(
             'label'    => Mage::helper('eavmgmt')->__('Export Option'),
             'url'      => $this->getUrl('*/*/massExportOptions'),
        ));
        return $this;
    }

}
