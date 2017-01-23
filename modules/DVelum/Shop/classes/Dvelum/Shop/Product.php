<?php
class Dvelum_Shop_Product
{
    protected $code;

    protected $id;

    protected $data;

    /**
     * @var Dvelum_Shop_Product_Config
     */
    protected $config;

    /**
     * @param string $code
     * @return Dvelum_Shop_Product
     */
    static public function factory($code)
    {
        return new static($code);
    }

    /**
     * Dvelum_Shop_Product constructor.
     * @param string $code
     */
    protected function __construct($code)
    {
        $this->code = $code;
        $this->config = Dvelum_Shop_Product_Config::factory($code);
    }

    /**
     * Set product id
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function setValues(array $data)
    {
        foreach ($data as $k=>$v){
            $this->set($k,$v);
        }
    }

    /**
     * Set product property value
     * @param string $key
     * @param mixed $val
     * @throws Exception
     */
    public function set($key, $val)
    {
        if(!$this->config->fieldExist($key)){
            throw new Exception('Undefined field '.$key.' for product '.$this->code);
        }

        $field = $this->config->getField($key);

        $value = $field->filter($val);
        if(!$field->isValid($value)){
            throw new Exception('Invalid value '.((string) $val).' for field '.$key);
        }

        $this->data[$key] = $value;
    }

    /**
     * Get product data
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get product id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get code of product classification
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get Product configuration object
     * @return Dvelum_Shop_Product_Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}