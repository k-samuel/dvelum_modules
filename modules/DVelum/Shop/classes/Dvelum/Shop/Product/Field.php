<?php
class Dvelum_Shop_Product_Field
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get field name
     * @return string
     */
    public function getName()
    {
        return $this->config['name'];
    }

    /**
     * Get field title (label)
     * @return string
     */
    public function getTitle()
    {
        return $this->config['title'];
    }

    /**
     * Get data as array
     * @return array
     */
    public function __toArray()
    {
        return $this->config;
    }
}