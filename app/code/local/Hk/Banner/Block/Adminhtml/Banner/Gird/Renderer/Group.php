<?php
class Hk_Banner_Block_Adminhtml_Banner_Grid_Renderer_Group extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $options = array();

        // Fetch data from your table and populate the options array
        $collection = Mage::getModel('banner/bannergroup')->getCollection();
        foreach ($collection as $item) {
            $options[] = array(
                'value' => $item->getId(),
                'label' => $item->getName()
            );
        }

        return $options;
    }
}