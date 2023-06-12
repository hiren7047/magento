<?php 

class Hk_Vendor_Block_Adminhtml_Vendor_Grid_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $status = $row->getStatus();
        switch ($status) {
            case '1':
                $label = 'Active';
                break;
            case '0':
                $label = 'InActive';
                break;
        }
        return $label;
    }
}