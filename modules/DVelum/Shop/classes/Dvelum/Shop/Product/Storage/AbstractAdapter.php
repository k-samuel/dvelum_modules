<?php
abstract class Dvelum_Shop_Product_Storage_AbstractAdapter
{
    /**
     * Storage configuration
     * @var Config_Abstract
     */
    protected $config;

    public function __construct(Config_Abstract $config)
    {
        $this->config = $config;
    }

    /**
     * Load product
     * @param integer $productId
     * @return Dvelum_Shop_Product
     * @throws Exception
     */
    abstract public function load($productId);

    /**
     * Load products by id
     * @param array $productIds
     * @return Dvelum_Shop_Product[]
     */
    abstract public function loadProducts(array $productIds);

    /**
     * Save product
     * @param Dvelum_Shop_Product $product
     * @return boolean
     */
    abstract public function save(Dvelum_Shop_Product $product);

    /**
     * Find Products
     * @param array|boolean $filters
     * @param array|boolean $params (sorting, limit)
     * @return mixed
     */
    abstract public function find($filters = false, $params = false);
}