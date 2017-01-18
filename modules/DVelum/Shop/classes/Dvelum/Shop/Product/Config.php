<?php
class Dvelum_Shop_Product_Config
{
    static protected $instances;
    static protected $initialized = false;

    /**
     * @var array
     */
    static protected $config = null;

    protected $id = null;
    protected $model = null;
    protected $data = [];

    /**
     * @param integer $id
     * @return  Dvelum_Shop_Product_Config
     */
    static public function factory($id)
    {
        if(static::$initialized){
            static::init();
        }
        if(!isset(static::$instances[$id])){
            static::$instances[$id] = new static($id);
        }
        return  static::$instances[$id];
    }

    static protected function init()
    {
        static::$config = Config::storage()->get('dvelum_shop.php')->get('product_config');
        static::$initialized = true;
    }

    /**
     * Dvelum_Shop_Product_Config constructor.
     * @param integer $id
     */
    protected function __construct($id)
    {
        $this->model = Model::factory(static::$config['object']);
        $this->load($id);
    }

    protected function load($id)
    {
        $this->id = $id;
        $this->data = $this->model->getItem($id);
        $this->data['fields'] = $this->initFields(json_decode($this->data['fields'],true));
    }

    /**
     * Initialize product fields
     * @param array $data
     * @return array
     */
    protected function initFields(array $data)
    {
        $data = array_merge($data,static::$config['fields']);
        $result = [];
        foreach ($data as $name=>$fieldConfig){
            $result[$name] = new Dvelum_Shop_Product_Field($fieldConfig);
        }
        return $result;
    }

    /**
     * Get config identifier
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}