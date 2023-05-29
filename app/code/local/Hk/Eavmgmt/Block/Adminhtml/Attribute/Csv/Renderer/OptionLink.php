<?php

class Hk_Eavmgmt_Block_Adminhtml_Attribute_Csv_Renderer_OptionLink extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract       
{
    
      function render($row)
    {
        $collection = Mage::getModel('eav/entity_attribute_option')->getCollection();
        $collection->getSelect()
                    ->join('eav_attribute', 'main_table.attribute_id = eav_attribute.attribute_id', 'attribute_code')
                    ->where('main_table.attribute_id = ?',$row->getId());

        $inputType = $row->getFrontendInput();

        $array = array('select','multiselect');
        if (in_array($inputType,$array)) {
            $link = "<a href = '{$this->getUrl('*/*/option',['attribute_id'=>$row->getId()])}'>Options(".count($collection->getData()).")</a>";
            return $link;
        }
        return null;
    }
}