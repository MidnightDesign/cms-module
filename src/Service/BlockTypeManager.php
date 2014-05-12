<?php

namespace Midnight\CmsModule\Service;

use Midnight\Block\BlockInterface;
use Midnight\Block\Renderer\RendererInterface;
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
        foreach ($this->types as $type) {
            if ($block instanceof $type['class']) {
                if (!isset($type['renderer'])) {
                    throw new \RuntimeException(sprintf(
                        'The configuration for %s is missing a "renderer" key.',
                        $type['class']
                    ));
                }
                return $type['renderer'];
            }
        }
        throw new UnknownBlockTypeException(sprintf('Unknown block %s.', get_class($block)));
    }
}