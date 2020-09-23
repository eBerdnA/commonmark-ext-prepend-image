<?php

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Environment;
use PHPUnit\Framework\TestCase;
use AndreBering\CommonMarkExtension\PrependImageExtension;

class PrependImageExtensionTest extends TestCase
{
    protected $environment;
    protected $basePath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->environment = Environment::createCommonMarkEnvironment();
        $this->basePath = '/path/to/files/';
        $imageExtension = new PrependImageExtension($this->basePath);
        $this->environment->addExtension($imageExtension);

        $this->environment->addExtension($imageExtension);
    }

    public function testTheRendererIsAdded()
    {
        $this->assertCount(3, $this->getImageRenderers($this->environment));
    }

    public function testNothingIsDone()
    {
        $converter = new CommonMarkConverter([], $this->environment);

        $html = $converter->convertToHtml('![alt text](http://example.org/image.jpg)');

        $this->assertStringContainsString('<p><img src="http://example.org/image.jpg" alt="alt text" /></p>', $html);
    }

    public function testNothingIsDone2()
    {
        $converter = new CommonMarkConverter([], $this->environment);

        $html = $converter->convertToHtml('![alt text](//example.org/image.jpg)');

        $this->assertStringContainsString('<p><img src="//example.org/image.jpg" alt="alt text" /></p>', $html);
    }

    public function testNothingIsDone3()
    {
        $converter = new CommonMarkConverter([], $this->environment);

        $html = $converter->convertToHtml('![alt text](/given-path/image.jpg)');

        $this->assertStringContainsString('<p><img src="/given-path/image.jpg" alt="alt text" /></p>', $html);
    }

    public function testBasePathIsAdded()
    {
        $converter = new CommonMarkConverter([], $this->environment);

        $html = $converter->convertToHtml('![alt text](image.jpg)');

        $this->assertStringContainsString('<p><img src="'.$this->basePath.'image.jpg" alt="alt text" /></p>', $html);
    }

    /**
     * @param ConfigurableEnvironmentInterface $environment
     * @return array
     */
    private function getImageRenderers(ConfigurableEnvironmentInterface $environment)
    {
        return iterator_to_array($environment->getInlineRenderersForClass('League\CommonMark\Inline\Element\Image'));
    }
}