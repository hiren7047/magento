<?php
class Ccc_Practice_Block_Adminhtml_Query_Renderer_Color extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    function render($row)
    {
        return (int)$row->getColor();
    }
}