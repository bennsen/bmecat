<?php
/**
 * This file is part of the BMEcat php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SE\Component\BMEcat\Tests;

use PHPUnit\Framework\TestCase;
use SE\Component\BMEcat\Exception\UnknownNodeException;
use SE\Component\BMEcat\Exception\UnknownNodeTypeException;
use SE\Component\BMEcat\NodeLoader;

/**
 *
 * @package SE\Component\BMEcat\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class NodeLoaderTest extends TestCase
{
    /**
     *
     * @var NodeLoader
     */
    protected $loader;

    /**
     *
     * Sets up a default loader instance
     */
    public function setUp() : void
    {
        $this->loader = new NodeLoader;
    }

    /**
     *
     * @test
     */
    public function Can_Be_Instantiated()
    {
        $this->assertInstanceOf('SE\Component\BMEcat\NodeLoader', $this->loader);
    }

    /**
     *
     * @test
     */
    public function Default_Mapping_Is_Ensured()
    {
        $map = [
            $this->loader->get(NodeLoader::PRODUCT_DETAILS_NODE),
            $this->loader->get(NodeLoader::PRODUCT_FEATURE_NODE),
            $this->loader->get(NodeLoader::PRODUCT_PRICE_NODE),
            $this->loader->get(NodeLoader::PRODUCT_NODE),
            $this->loader->get(NodeLoader::CATALOG_NODE),
            $this->loader->get(NodeLoader::DOCUMENT_NODE),
            $this->loader->get(NodeLoader::NEW_CATALOG_NODE),
            $this->loader->get(NodeLoader::HEADER_NODE),
            $this->loader->get(NodeLoader::SUPPLIER_NODE),
        ];

        $this->assertSame([
            '\SE\Component\BMEcat\Node\ProductDetailsNode',
            '\SE\Component\BMEcat\Node\ProductFeatureNode',
            '\SE\Component\BMEcat\Node\ProductPriceNode',
            '\SE\Component\BMEcat\Node\ProductNode',
            '\SE\Component\BMEcat\Node\CatalogNode',
            '\SE\Component\BMEcat\Node\DocumentNode',
            '\SE\Component\BMEcat\Node\NewCatalogNode',
            '\SE\Component\BMEcat\Node\HeaderNode',
            '\SE\Component\BMEcat\Node\SupplierNode',
        ], $map);
    }

    /**
     *
     * @test
     */
    public function Default_Mapping_Returns_Default_Class()
    {
        $instance = $this->loader->getInstance(NodeLoader::PRODUCT_NODE);
        $this->assertInstanceOf('\SE\Component\BMEcat\Node\ProductNode', $instance);
    }

    /**
     *
     * @test
     */
    public function Custom_Mapping_Returns_Custom_Class()
    {
        $class = '\SE\Component\BMEcat\Tests\Fixtures\CustomProductNodeFixture';
        $this->loader->set(NodeLoader::PRODUCT_NODE, $class);
        $this->assertSame($class, $this->loader->get(NodeLoader::PRODUCT_NODE));

        $instance = $this->loader->getInstance(NodeLoader::PRODUCT_NODE);
        $this->assertInstanceOf($class, $instance);
        $this->assertInstanceOf('\SE\Component\BMEcat\Node\ProductNode', $instance);
    }

    /**
     *
     * @test
     */
    public function Get_Unknown_Node_Class()
    {
        $this->expectException(UnknownNodeTypeException::class);
        $this->loader->get('unknown.node');
    }

    /**
     *
     * @test
     */
    public function Set_Unknown_Node_Class()
    {
        $this->expectException(UnknownNodeTypeException::class);
        $this->loader->set('unknown.node', '\SE\Component\BMEcat\Node\ProductNode');
    }

    /**
     *
     * @test
     */
    public function Get_Unknown_Node_Instance()
    {
        $this->expectException(UnknownNodeException::class);
        $this->loader->getInstance('unknown.node');
    }


}