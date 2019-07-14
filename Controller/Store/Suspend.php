<?php

namespace Kryten\SuspendStore\Controller\Store;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Controller\Result\ForwardFactory;

/**
 * Description of Suspend
 *
 * @author Garry Childs <info@freedomwebservices.net>
 */
class Suspend extends Action
{

    /**
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     *
     * @var ScopeConfigInterface 
     */
    protected $scopeConfig;
    
    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory, ScopeConfigInterface $scopeConfig, ForwardFactory $resultForwardFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig;
        $this->resultForwardFactory = $resultForwardFactory;
    }

    public function execute()
    {
        if ($cmsPage = $this->scopeConfig->getValue('suspend/general/cmspage', ScopeInterface::SCOPE_STORE)) {
            $resultPage = $this->_objectManager->get('Magento\Cms\Helper\Page')->prepareResultPage($this, $cmsPage);
        } else {
            $resultPage = $this->resultPageFactory->create();
        }
        if (!$resultPage) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        $resultPage->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0', true);
        $resultPage->getConfig()->getTitle()->prepend(_('Store Suspended'));

        return $resultPage;
    }

}
