<?php

namespace AndreBering\CommonMarkExtension;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Inline\Renderer\ImageRenderer;

use League\CommonMark\HtmlElement;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Util\ConfigurationInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class PrependImageRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    protected $config;

    /** @var ImageRenderer */
    protected $baseImageRenderer;

    /** @var ConfigurableEnvironmentInterface */
    private $environment;

    private $basePath;

    /**
     * @param ConfigurableEnvironmentInterface $environment
     * @param ImageRenderer $baseImageRenderer
     */
    public function __construct(ConfigurableEnvironmentInterface $environment, ImageRenderer $baseImageRenderer)
    {
        $this->baseImageRenderer = $baseImageRenderer;
        $this->environment = $environment;
    }

    /**
     * @param String @basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param AbstractInline $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        $this->baseImageRenderer->setConfiguration($this->config);
        $baseImage = $this->baseImageRenderer->render($inline, $htmlRenderer);
        
        if (!PrependImageHelper::startsWith($baseImage->getAttribute('src'), '/') && 
            !PrependImageHelper::startsWith($baseImage->getAttribute('src'), '//') && 
            !PrependImageHelper::startsWith($baseImage->getAttribute('src'), 'http')) {
                $baseImage->setAttribute('src', $this->basePath . $baseImage->getAttribute('src'));
        }
        
        return $baseImage;
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}