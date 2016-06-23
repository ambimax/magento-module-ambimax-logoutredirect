<?php

class Ambimax_LogoutRedirect_Model_Observer
{
    /**
     * Redirects to custom url after logout if set in system > configuration > customer > startup
     *
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function logoutRedirect(Varien_Event_Observer $observer)
    {
        if( ! Mage::getStoreConfigFlag('customer/startup/redirect_logout')) {
            return $this;
        }

        $transportObj = new Varien_Object(array(
            'url' => Mage::getStoreConfig('customer/startup/redirect_logout_url'),
            'code' => 302,
        ));
        Mage::dispatchEvent('ambimax_logoutredirect', array('data' => $transportObj));

        /** @var Mage_Customer_AccountController $controller */
        $controller = $observer->getControllerAction();
        $controller->getResponse()->setRedirect($transportObj->getUrl(), $transportObj->getCode());
    }
}
