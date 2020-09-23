<?php

use PHPUnit\Framework\TestCase;
use AndreBering\CommonMarkExtension\PrependImageHelper;

class PrependImageHelperTest extends TestCase
{
    public function testStartsWith() : void
    {
        $haystack = 'http://example.org';
        $haystack2 = 'https://example.org';
        $needle = 'http';
        $this->assertTrue(PrependImageHelper::startsWith($haystack, $needle));
        $this->assertTrue(PrependImageHelper::startsWith($haystack2, $needle));
    }

    public function testEndsWith() : void
    {
        $haystack = 'http://example.org';
        $needle = '.org';
        $needle2 = '2.org';
        $this->assertTrue(PrependImageHelper::endsWith($haystack, $needle));
        $this->assertFalse(PrependImageHelper::endsWith($haystack, $needle2));
    }
}