<?php

namespace Kryten\SuspendStore\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;

/**
 * Suspend
 *
 * @author Garry Childs <info@freedomwebservices.net>
 */
class Suspend implements ObserverInterface
{

    /**
     *
     * @var ScopeConfigInterface 
     */
    protected $scopeConfig;

    /**
     *
     * @var UrlInterface 
     */
    private $url;

    public function __construct(ScopeConfigInterface $scopeConfig, UrlInterface $url)
    {
        $this->scopeConfig = $scopeConfig;
        $this->url = $url;
    }

    public function execute(Observer $observer)
    {
        if ($observer->getRequest()->getRouteName() != 'suspend' && $this->scopeConfig->getValue('suspend/general/suspendstore', ScopeInterface::SCOPE_STORE) == 1) {
            $observer->getControllerAction()->getResponse()->setRedirect($this->url->getUrl('store/store/suspend'))->sendResponse();
            exit(0);
        }
        return $this;
    }

}
