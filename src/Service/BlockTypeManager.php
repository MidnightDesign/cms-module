<?php

namespace Midnight\CmsModule\Service;

use Midnight\Block\BlockInterface;
use Midnight\Block\Renderer\RendererInterface;
use Midnight\CmsModule\Exception\MissingConfigException;
use Midnight\CmsModule\Exception\UnknownBlockTypeException;

class BlockTypeManager implements BlockTypeManagerInterface
{
    /**
     * @var array
     */
    private $types;

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
    private function getConfigFor(BlockInterface $block)
    {
        foreach ($this->types as $type) {
            if ($block instanceof $type['class']) {
                return $type;
            }
        }
        throw new UnknownBlockTypeException(sprintf('Unknown block %s.', get_class($block)));
    }
}
