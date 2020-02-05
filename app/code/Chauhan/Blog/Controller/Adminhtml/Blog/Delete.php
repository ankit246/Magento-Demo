<?php

namespace Chauhan\Blog\Controller\Adminhtml\Blog;

use Chauhan\Blog\Model\Blog;
use Chauhan\Blog\Model\Config;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action
{
    private $config;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Config $config
    ) {
        $this->config = $config;
        parent::__construct($context);
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($this->config->isEnabled()) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            // check if we know what should be deleted
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    // init model and delete
                    $model = $this->_objectManager->create(Blog::class);
                    $model->load($id);
                    // $model->setDeletedAt(date("Y-m-d h:i:sa"))->save();
                    $model->delete();
                    // display success message
                    $this->messageManager->addSuccessMessage(__('You deleted the blog.'));
                    // go to grid
                    return $resultRedirect->setPath('*/');
                } catch (\Exception $e) {
                    // display error message
                    $this->messageManager->addErrorMessage($e->getMessage());
                    // go back to edit form
                    return $resultRedirect->setPath('*/', ['id' => $id]);
                }
            }
            // display error message
            $this->messageManager->addErrorMessage(__('We can\'t find a blog to delete.'));
            // go to grid
            return $resultRedirect->setPath('*/*/');
        }
        // display error message
        $this->messageManager->addErrorMessage(__('Module is disabled.'));
        // go to grid
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
