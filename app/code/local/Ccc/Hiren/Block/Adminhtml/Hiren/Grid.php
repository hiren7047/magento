<?php 

class Ccc_Hiren_Block_Adminhtml_Hiren_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct(){
		parent::__construct();
		$this->setId('hirenId');
		$this->setDefaultSort('entity_Id');
		$this->setDeafultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setVarNameFilter('hiren_filter');
	}

    protected function _prepareCollection()
    {

        $attributesCodes = Mage::getResourceModel('hiren/hiren_attribute_collection')->getItems();
        $collection = Mage::getModel('hiren/hiren')->getCollection();
        foreach($attributesCodes as $attributecode)
        {
             $collection->addAttributeToSelect($attributecode->attribute_code);
        }

        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
       
        $collection->joinAttribute(
            'id',
            'hiren/entity_id',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

	protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => Mage::helper('hiren')->__('id'),
                'width'  => '50px',
                'index'  => 'id',
            ));
        $this->addColumn('firstname',
            array(
                'header' => Mage::helper('hiren')->__('First Name'),
                'width'  => '50px',
                'index'  => 'firstname',
            ));

        $this->addColumn('lastname',
            array(
                'header' => Mage::helper('hiren')->__('Last Name'),
                'width'  => '50px',
                'index'  => 'lastname',
            ));

        $this->addColumn('email',
            array(
                'header' => Mage::helper('hiren')->__('Email'),
                'width'  => '50px',
                'index'  => 'email',
            ));
        $this->addColumn('test',
            array(
                'header' => Mage::helper('hiren')->__('Test'),
                'width'  => '50px',
                'index'  => 'test',
            ));
        
        parent::_prepareColumns();
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id'    => $row->getId())
        );
    }
}