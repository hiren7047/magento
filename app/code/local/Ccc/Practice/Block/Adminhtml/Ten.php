<?php
class Ccc_Practice_Block_Adminhtml_Ten extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'practice';
        $this->_controller = 'adminhtml_ten';
        $this->_headerText = Mage::helper('practice')->__('Tenth Task');
        parent::__construct();
        $this->_removeButton('add');
    }

    public function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->addButton('show_query', array(
            'label'   => Mage::helper('product')->__('Show Query'),
            'onclick' => "setLocation('{$this->getUrl('practice/query/tenQuery')}')",
            'class'   => 'show_query',
        ));

        return $this;
    }

}