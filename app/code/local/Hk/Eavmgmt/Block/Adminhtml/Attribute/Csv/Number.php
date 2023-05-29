<?php

class Hk_Eavmgmt_Block_Adminhtml_Attribute_Csv_Number extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract       
{
    
   
    public $index = 0;
    
    function render($row)
    {
        $this->index++;
        return $this->getIndex();
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }
}