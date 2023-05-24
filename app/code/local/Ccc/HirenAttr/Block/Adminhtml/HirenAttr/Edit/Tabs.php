<?php 

class Ccc_HirenAttr_Block_Adminhtml_HirenAttr_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
        parent::__construct();
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('hirenAttr')->__('HirenAttr Information'));
	}

	public function getHirenAttr()
    {
        return Mage::registry('current_hirenAttr');
    }

    protected function _beforeToHtml()
    {
        $hirenAttr = Mage::registry('current_hirenAttr');
        $setModel = Mage::getModel('eav/entity_attribute_set');

        if (!($setId = $hirenAttr->getAttributeSetId())) {
            $setId = $this->getRequest()->getParam('set', null);
        }

        if ($setModel->load($setId)->getAttributeSetId()) {
            
            $hirenAttrAttributes = Mage::getResourceModel('hirenAttr/hirenAttr_attribute_collection');

            if (!$hirenAttr->getId()) {
                foreach ($hirenAttrAttributes as $attribute) {
                    $default = $attribute->getDefaultValue();
                    if ($default != '') {
                        $hirenAttr->setData($attribute->getAttributeCode(), $default);
                    }
                }
            }

            $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
                ->setAttributeSetFilter($setId)
                ->setSortOrder()
                ->load();

            $defaultGroupId = 0;
            foreach ($groupCollection as $group) {
                if ($defaultGroupId == 0 or $group->getIsDefault()) {
                    $defaultGroupId = $group->getId();
                }

            }	

            foreach ($groupCollection as $group) {
                $attributes = array();
                foreach ($hirenAttrAttributes as $attribute) {
                    if ($hirenAttr->checkInGroup($attribute->getId(),$setId, $group->getId())) {
                        $attributes[] = $attribute;
                    }
                }

                if (!$attributes) {
                    continue;
                }

                $active = $defaultGroupId == $group->getId();
                $block = $this->getLayout()->createBlock('hirenAttr/adminhtml_hirenAttr_edit_tab_attributes')
                    ->setGroup($group)
                    ->setAttributes($attributes)
                    ->setAddHiddenFields($active)
                    ->toHtml();

                $this->addTab('group_' . $group->getId(), array(
                    'label'     => Mage::helper('hirenAttr')->__($group->getAttributeGroupName()),
                    'content'   => $block,
                    'active'    => $active
                ));
            }
        } else {
            $this->addTab('set', array(
                'label'     => Mage::helper('hirenAttr')->__('Settings'),
                'content'   => $this->_translateHtml($this->getLayout()
                    ->createBlock('hirenAttr/adminhtml_hirenAttr_edit_tab_setting')->toHtml()),
                'active'    => true
            ));
        }
      return parent::_beforeToHtml();
    }

    protected function _translateHtml($html)
    {
        Mage::getSingleton('core/translate_inline')->processResponseBody($html);
        return $html;
    }
}