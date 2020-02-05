<?php

namespace Chauhan\Blog\Block\Adminhtml\Blog;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    /**
     * Initialize blog post edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Chauhan_Blog';
        $this->_controller = 'adminhtml_blog';
        parent::_construct();
        $this->buttonList->remove('back');
        $this->addButton(
            'my_back_button',
            [
                'label' => __('Back'),
                'onclick' => 'setLocation(\'' . $this->getUrl('blog') . '\')',
                'class' => 'back'
            ],
            -1
        );
        if ($this->_isAllowedAction('Chauhan_Blog::save')) {
            $this->buttonList->update('save', 'label', __('Save Blog Post'));
        } else {
            $this->buttonList->remove('save');
        }
        if ($this->_isAllowedAction('Chauhan_Blog::blog_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Blog'));
        } else {
            $this->buttonList->remove('delete');
        }
    }
    /**
     * Retrieve text for header element depending on loaded post
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('blog')->getId()) {
            return __("Edit Post '%1'", $this->escapeHtml($this->_coreRegistry->registry('blog')->getTitle()));
        } else {
            return __('New Post');
        }
    }
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('blog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}
