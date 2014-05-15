<?php

namespace Midnight\CmsModule\Service;

use Exception;
use Midnight\Block\BlockInterface;
use Midnight\Block\Renderer\RendererInterface;
use Midnight\CmsModule\Exception\MissingConfigException;
use Midnight\CmsModule\Exception\UnknownBlockTypeException;
use Midnight\CmsModule\InlineBlockOption\InlineOptionsProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlockTypeManager implements BlockTypeManagerInterface, ServiceLocatorAwareInterface
{
    /**
     * @var array
     */
    private $types;
    /**
     * @var InlineOptionsProviderInterface
     */
    private $defaultInlineOptionsProvider;
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @param array $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * @param BlockInterface $block
     *
     * @throws UnknownBlockTypeException
     * @return RendererInterface
     */
    public function getRendererFor(BlockInterface $block)
    {
        $type = $this->getConfigFor($block);
        if (!isset($type['renderer'])) {
            throw new MissingConfigException(sprintf(
                'The configuration for %s is missing a "renderer" key.',
                $type['class']
            ));
        }
        return $type['renderer'];
    }

    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function getPreviewRendererFor(BlockInterface $block)
    {
        $type = $this->getConfigFor($block);
        if (!isset($type['preview_renderer'])) {
            throw new MissingConfigException(sprintf(
                'The configuration for %s is missing a "preview_renderer" key.',
                $type['class']
            ));
        }
        return $type['preview_renderer'];
    }

    /**
     * @param BlockInterface $block
     *
     * @return array
     */
    public function getConfigFor(BlockInterface $block)
    {
        foreach ($this->types as $type) {
            if ($block instanceof $type['class']) {
                return $type;
            }
        }
        throw new UnknownBlockTypeException(sprintf('Unknown block %s.', get_class($block)));
    }

    /**
     * @param BlockInterface $block
     *
     * @return InlineOptionsProviderInterface
     */
    public function getInlineOptionsProviderFor($block)
    {
        $blockConfig = $this->getConfigFor($block);
        if (empty($blockConfig['inline_options_provider'])) {
            return $this->getDefaultInlineOptionsProvider();
        }
        return $this->getServiceLocator()->get($blockConfig['inline_options_provider']);
    }

    /**
     * @throws Exception
     * @return InlineOptionsProviderInterface
     */
    private function getDefaultInlineOptionsProvider()
    {
        if (!$this->defaultInlineOptionsProvider) {
            throw new Exception('There is no default inline options provider set.');
        }
        return $this->defaultInlineOptionsProvider;
    }

    /**
     * @param InlineOptionsProviderInterface $defaultInlineOptionsProvider
     */
    public function setDefaultInlineOptionsProvider($defaultInlineOptionsProvider)
    {
        $this->defaultInlineOptionsProvider = $defaultInlineOptionsProvider;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function getInlineContainerClassFor(BlockInterface $block)
    {
        $blockConfig = $this->getConfigFor($block);
        if (empty($blockConfig['inline_container_class'])) {
            return null;
        }
        return $blockConfig['inline_container_class'];
    }
}
