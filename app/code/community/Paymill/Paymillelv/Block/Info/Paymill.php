<?php

class Paymill_Paymillelv_Block_Info_Paymill extends Mage_Payment_Block_Info_Cc
{
    /**
     * Prepare payment info
     *
     * @param Varien_Object|array $transport
     * @return Varien_Object
     */
    protected function _prepareSpecificInformation($transport = null)
    {
        $transport = parent::_prepareSpecificInformation($transport);
        $additionalInformation = array();
        if(Mage::app()->getStore()->isAdmin()) {
			$order = Mage::registry('current_order');
        	if(!$order && Mage::registry('current_shipment'))	$order = Mage::registry('current_shipment')->getOrder();
        	if(!$order && Mage::registry('current_invoice'))	$order = Mage::registry('current_invoice')->getOrder();
        	if(!$order && Mage::registry('current_creditmemo'))	$order = Mage::registry('current_creditmemo')->getOrder();
        	if(!$order && Mage::app()->getRequest()->getParam('order_id'))
        		$order = Mage::getModel('sales/order')->load(Mage::app()->getRequest()->getParam('order_id'));
        	
            $additionalInformation = array(
                'Transaction ID' => ' ' . $order->getPayment()
                                            ->getAdditionalInformation('paymill_transaction_id')
            );
        }
        return $transport->setData($additionalInformation);
    }
}
