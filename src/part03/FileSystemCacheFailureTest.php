<?php
namespace org\bovigo\vfs\examples\part03;
use org\bovigo\vfs\vfsStream;

class FileSystemCacheFailureTest extends \PHPUnit_Framework_TestCase
{
    private $root;

    public function setUp() {
        $this->root = vfsStream::setup();
    }

    /**
     * @test
     */
    public function returnsTrueWhenNoFailureOccurs() {
        $cache = new FileSystemCache($this->root->url() . '/cache');
        $this->assertTrue($cache->store('example', ['bar' => 303]));
    }

    /**
     * @test
     * @expectedException  \Exception
     */
    public function returnsFalseWhenFailureOccurs() {
        $file  = vfsStream::newFile('example', 0000)
                          ->withContent('notoverwritten')
                          ->at($this->root);
        $cache = new FileSystemCache($this->root->url());
        $cache->store('example', ['bar' => 303]);
    }
}
