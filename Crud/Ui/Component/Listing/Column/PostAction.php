<?php

namespace Magestudy\Crud\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;
use Magestudy\Crud\Api\Data\PostInterface;

class PostAction extends AbstractAction
{
    /** Url path */
    const PATH_EDIT = 'crud/post/edit';
    const PATH_DELETE = 'crud/post/delete';

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $urlBuilder, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item[PostInterface::ID])) {
                    $item[$name]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            $this->_editUrl, [self::FRONTEND_ID => $item[PostInterface::ID]]
                        ),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            self::PATH_DELETE,
                            [self::FRONTEND_ID => $item[PostInterface::ID]]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete') . ' ' . $item[PostInterface::TITLE],
                            'message' => __(
                                'Are you sure you wan\'t to delete a record?'
                            )
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }

    /**
     * @return string
     */
    protected function getEditUrl()
    {
        return self::PATH_EDIT;
    }
}
