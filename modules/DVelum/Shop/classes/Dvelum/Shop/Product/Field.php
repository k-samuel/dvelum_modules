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

    /**
     * Validate Value
     * @param $value
     * @return boolean
     */
    public function isValid($value)
    {
        if(is_string($value) || is_bool($value) || is_numeric($value) || is_null($value)){
            return true;
        }
        return false;
    }

    /**
     * Filter value
     * @param mixed $value
     * @return mixed
     */
    public function filter($value)
    {
        if($this->config['multivalue'] && !is_array($value)){
            $value = [$value];
        }
        return $value;
    }

    /**
     * Is system field
     * @return boolean
     */
    public function isSystem()
    {
        if(isset($this->config['system']) && $this->config['system']){
            return true;
        }
        return false;
    }

    /**
     * Is multi-value field
     */
    public function isMultiValue()
    {
        if(isset($this->config['multivalue']) && $this->config['multivalue']){
            return true;
        }
        return false;
    }

    /**
     * Get field type
     * @return mixed
     */
    public function getType()
    {
        return $this->config['type'];
    }
}