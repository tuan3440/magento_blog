<?php

namespace Dco\Service\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;

class NonCategoryLink
{
    protected $nodeFactory;

    public function __construct(
        NodeFactory $nodeFactory
    ) {
        $this->nodeFactory = $nodeFactory;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
                                          $outermostClass = '',
                                          $childrenWrapClass = '',
                                          $limit = 0
    ) {
        $nodes = $this->getNodeAsArray();
        foreach ($nodes as $subnote) {
            $node = $this->nodeFactory->create(
                [
                    'data' => $subnote,
                    'idField' => 'id',
                    'tree' => $subject->getMenu()->getTree()
                ]
            );
            $subject->getMenu()->addChild($node);
        }
    }

    protected function getNodeAsArray()
    {
        return [
            [
            'name' => __('Service'),
            'id' => 'menuitem_service',
            'url' => 'bookings',
            'has_active' => false,
            'is_active' => false
            ],
            [
                'name' => __('Health Blog'),
                'id' => 'menuitem_blog',
                'url' => 'blog',
                'has_active' => false,
                'is_active' => false
            ]
        ];
    }

}
