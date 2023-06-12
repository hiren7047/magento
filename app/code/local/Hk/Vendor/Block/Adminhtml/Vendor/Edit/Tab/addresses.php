<?php

class Hk_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Addresses extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('vendor_form', array('legend' => Mage::helper('vendor')->__('Vendor Addresses')));

        $fieldset->addField('address', 'text', array(
            'label'    => Mage::helper('vendor')->__('Address'),
            'required' => false,
            'name'     => 'address[address]',
        ));

        $fieldset->addField('city', 'text', array(
            'label'    => Mage::helper('vendor')->__('City'),
            'required' => false,
            'name'     => 'address[city]'
        ));

        $countryCollection = Mage::getModel('directory/country')->getCollection();
        $countryOptions = array();
        foreach ($countryCollection as $country) {
            $countryOptions[$country->getId()] = $country->getName();
        }

        $fieldset->addField('country', 'select', array(
            'label'    => 'Country',
            'name'     => 'address[country]',
            'values'   => $countryOptions,
            'required' => true,
            'onchange' => 'getStates(this.value)'
        ));

     $stateOptions = array();
        $fieldset->addField('state', 'select', array(
            'label'    => 'State',
            'name'     => 'address[state]',
            'values'   => $stateOptions,
            'required' => true
        ));

        $countryField = $form->getElement('country');
        $registry = Mage::registry('address_edit')->getData();
        $countryField->setValue($registry['country']);
        $countryField->setAfterElementHtml('
            <script type="text/javascript">
                document.observe("dom:loaded", function() {
                    getStates("' . $registry['country'] . '");
                });
                function getStates(countryId) {
                    var url = \'' . $this->getUrl('vendor/adminhtml_vendor/states') . '\';
                    
                    var stateElement = $("state");
                    new Ajax.Request(url, {
                        method: "post",
                        parameters: {
                            country_id: countryId
                        },
                        onSuccess: function(response) {
                            var stateOptions = JSON.parse(response.responseText);
                            var optionsHtml = "";
                            stateOptions.forEach(function(option) {
                                optionsHtml += "<option value=\"" + option.value + "\"";
                                if (option.value == "' . $registry['state'] . '") {
                                    optionsHtml += " selected";
                                }
                                optionsHtml += ">" + option.label + "</option>";
                            });
                            stateElement.update(optionsHtml);
                        },
                        onFailure: function() {
                            stateElement.update("");
                        }
                    });
                }
            </script>
        ');

        $fieldset->addField('zipcode', 'text', array(
            'label'    => Mage::helper('vendor')->__('Zipcode'),
            'required' => false,
            'name'     => 'address[zipcode]'
        ));

        if (Mage::getSingleton('adminhtml/session')->getVendorData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } elseif (Mage::registry('address_edit')) {
            $form->setValues(Mage::registry('address_edit')->getData());
        }
        return parent::_prepareForm();
    }
}
