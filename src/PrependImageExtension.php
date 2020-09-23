<?php

namespace AndreBering\CommonMarkExtension;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Inline\Renderer\ImageRenderer;

class PrependImageExtension implements ExtensionInterface
{
    private $prependImageRenderer;
    private $basePath;

    /**
     * @param String $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $this->prependImageRenderer = new PrependImageRenderer($environment, new ImageRenderer());
        $this->prependImageRenderer->setBasePath($this->basePath);
        $environment->addInlineRenderer('League\CommonMark\Inline\Element\Image', $this->prependImageRenderer, 10);
    }
}