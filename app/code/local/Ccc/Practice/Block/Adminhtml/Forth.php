<?php
class Ccc_Practice_Block_Adminhtml_Forth extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'practice';
        $this->_controller = 'adminhtml_forth';
        $this->_headerText = Mage::helper('practice')->__('Forth Task');
        parent::__construct();
        $this->_removeButton('add');
    }

    public function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->addButton('show_query', array(
            'label'   => Mage::helper('product')->__('Show Query'),
            'onclick' => "setLocation('{$this->getUrl('practice/query/forthQuery')}')",
            'class'   => 'show_query',
        ));

        return $this;
    }

}