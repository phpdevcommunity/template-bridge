<?php

namespace Test\PhpDevCommunity\TemplateBridge\Renderer;

use PhpDevCommunity\TemplateBridge\Renderer\PhpRenderer;
use PhpDevCommunity\UniTester\TestCase;

final class PhpRendererTest extends TestCase
{
    private PhpRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new PhpRenderer(__DIR__ . '/views');
    }

    protected function tearDown(): void
    {
    }

    protected function execute(): void
    {
       $this->testRenderBasicView();
       $this->testRenderViewWithLayout();
       $this->testRenderViewWithBlock();
       $this->testRenderViewWithExtendingBlock();
       $this->testStartAndEndBlocks();
       $this->testRenderViewNotFound();
    }

    public function testRenderBasicView(): void
    {
        $expectedOutput = 'Hello, World!';
        $output = $this->renderer->render('test.php', ['message' => 'Hello, World!']);
        $this->assertEquals($expectedOutput, $output);
    }

    public function testRenderViewWithLayout(): void
    {
        $expectedOutput = '<!DOCTYPE html><html lang="fr"><head><title></title></head><body class="body"></body></html>';
        $output = $this->renderer->render('test_layout.php');
        $this->assertEquals($expectedOutput, $output);
    }

    public function testRenderViewWithBlock(): void
    {
        $expectedOutput = '';
        $output = $this->renderer->render('test_block.php');
        $this->assertEquals($expectedOutput, $output);
    }

    public function testRenderViewWithExtendingBlock(): void
    {
        $expectedOutput = '<!DOCTYPE html><html lang="fr"><head><title>Page Title</title></head><body class="body">Page Content</body></html>';
        $output = $this->renderer->render('test_extends.php');
        $this->assertEquals($expectedOutput, $output);
    }

    public function testStartAndEndBlocks(): void
    {
        $this->renderer->startBlock('content');
        echo 'Block Content';
        $this->renderer->endBlock();

        $expectedOutput = 'Block Content';
        $output = $this->renderer->block('content');
        $this->assertEquals($expectedOutput, $output);
    }

    public function testRenderViewNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class, function () {
            $this->renderer->render('non_existent_template.php');
        });
    }

}
