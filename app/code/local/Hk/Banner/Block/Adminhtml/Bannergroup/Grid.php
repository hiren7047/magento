<?php
class Hk_Banner_Block_Adminhtml_Bannergroup_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerAdminhtmlBannerGrid');
        $this->setDefaultSort('group_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('banner/bannergroup')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('group_id', array(
            'header'    => Mage::helper('banner')->__('Group Id'),
            'align'     => 'left',
            'index'     => 'group_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('banner')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('group_key', array(
            'header'    => Mage::helper('banner')->__('Group Key'),
            'align'     => 'left',
            'index'     => 'group_key',
        ));

        $this->addColumn('height', array(
            'header'    => Mage::helper('banner')->__('Height'),
            'align'     => 'left',
            'index'     => 'height',
        ));

        $this->addColumn('width', array(
            'header'    => Mage::helper('banner')->__('Width'),
            'align'     => 'left',
            'index'     => 'width',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('group_id' => $row->getId()));
    }
}