<?php
class Ccc_Practice_Block_Adminhtml_Eight_Renderer_Value extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    function render($row)
    {
        return $row->getSoldQuantity() ? (int)$row->getSoldQuantity() : '0';
    }
}