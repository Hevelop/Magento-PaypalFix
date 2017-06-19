<?php

/* 
 * Daniele Pastori.
 * daniele.pastori@gmail.com
 */

class Full_PaypalFix_Model_Hostedpro_Request extends Mage_Paypal_Model_Hostedpro_Request{
     /**
     * Get order request data as array
     * also adds hidden tax amount
     * @param Mage_Sales_Model_Order $order
     * @return array
     */
    protected function _getOrderData(Mage_Sales_Model_Order $order)
    {
        $request = array(
            'subtotal'      => $this->_formatPrice($order->getBaseGrandTotal()),
            'invoice'       => $order->getIncrementId(),
            'address_override' => 'true',
            'currency_code'    => $order->getBaseCurrencyCode(),
            'buyer_email'      => $order->getCustomerEmail(),
        );

        // append to request billing address data
        if ($billingAddress = $order->getBillingAddress()) {
            $request = array_merge($request, $this->_getBillingAddress($billingAddress));
        }

        // append to request shipping address data
        if ($shippingAddress = $order->getShippingAddress()) {
            $request = array_merge($request, $this->_getShippingAddress($shippingAddress));
        }

        return $request;
    }
}