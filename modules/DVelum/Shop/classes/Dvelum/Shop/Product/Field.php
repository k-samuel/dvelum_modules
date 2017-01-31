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

    public function isList()
    {
        if($this->config['type'] == 'list'){
            return true;
        }
        return false;
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
     * Is required field
     */
    public function isRequired()
    {
        if(isset($this->config['required']) && $this->config['required']){
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

    /**
     * Get field config
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get min value
     * @return integer | null
     */
    public function getMinValue()
    {
        if(isset($this->config['minValue']) && strlen((string)$this->config['minValue'])){
            return  $this->config['minValue'];
        }
        return null;
    }

    /**
     * Get min value
     * @return integer | null
     */
    public function getMaxValue()
    {
        if(isset($this->config['maxValue']) && strlen((string)$this->config['maxValue'])){
            return  $this->config['maxValue'];
        }
        return null;
    }

    /**
     * Get accepted values
     * @return []
     */
    public function getList()
    {
        if(isset($this->config['list']) && !empty($this->config['list'])){
            return  $this->config['list'];
        }
        return [];
    }
}