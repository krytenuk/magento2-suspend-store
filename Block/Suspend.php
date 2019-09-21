<?php

namespace Kryten\SuspendStore\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Directory\Model\CountryFactory;
use Magento\Store\Model\ScopeInterface;

/**
 * Store Block
 *
 * @author Garry Childs (info@freedomwebservices.net)
 */
class Suspend extends Template
{

    private $_countryFactory;

    public function __construct(Context $context, CountryFactory $countryFactory, $data = array())
    {
        $this->_countryFactory = $countryFactory;
        parent::__construct($context, $data);
    }

    /**
     *

     * @return \Kryten\StoreConfig\Block\/Magento\Framework\App\Config     * @return /Magento\Framework\App\Config
     */
    public function getConfig()
    {
        return $this->_scopeConfig;
    }
    
    public function isCmsPage()
    {
        return (bool) $this->_scopeConfig->getValue('suspend/general/cmspage', ScopeInterface::SCOPE_STORE);
    }

    public function getStoreTitle()
    {
        return $this->_scopeConfig->getValue('general/store_information/name', ScopeInterface::SCOPE_STORE);
    }

    /**
     *
     * @return array
     */
    public function getStoreAddress()
    {
        $address = array();
        $address[] = $this->_scopeConfig->getValue('general/store_information/street_line1', ScopeInterface::SCOPE_STORE);
        $address[] = $this->_scopeConfig->getValue('general/store_information/street_line2', ScopeInterface::SCOPE_STORE);
        $address[] = $this->_scopeConfig->getValue('general/store_information/region_id', ScopeInterface::SCOPE_STORE);
        $address[] = $this->getCountryname($this->_scopeConfig->getValue('general/store_information/country_id', ScopeInterface::SCOPE_STORE));
        $address[] = $this->_scopeConfig->getValue('general/store_information/postcode', ScopeInterface::SCOPE_STORE);
        return $address;
    }

    /**
     *
     * @param string $countryCode
     * @return string
     */
    public function getCountryname($countryCode)
    {
        return $this->_countryFactory->create()->loadByCode($countryCode)->getName();
    }

    public function getStorePhone()
    {
        $phone = $this->_scopeConfig->getValue('general/store_information/phone', ScopeInterface::SCOPE_STORE);
        if (strpos($phone, '/') !== false) {
            $phone = array_map('trim', explode('/', $phone));
        } else {
            $phone = (array) $phone;
        }
        return $phone;
    }

}
