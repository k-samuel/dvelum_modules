<?php
class Dvelum_Shop_Product_Config
{
    static protected $instances;
    static protected $initialized = false;
    /**
     * @var array
     */
    static protected $config = null;
    /**
     * @var Lang $lang
     */
    static protected $lang = null;

    protected $id = null;
    protected $model = null;
    protected $data = [];

    static public function debug(){
        foreach (static::$instances as $config){
            echo $config->getId().' '.implode(', ',array_keys($config->getFieldsConfig()))."\n";
        }
    }

    /**
     * Create product configuration object
     * @param integer $id
     * @return  Dvelum_Shop_Product_Config
     * @throws Exception
     */
    static public function factory($id)
    {
        if(!static::$initialized){
            static::init();
        }

        if(!isset(static::$instances[$id])){
            $config = new static();
            $config->load($id);
            static::$instances[$id] = $config;
        }
        return  static::$instances[$id];
    }

    /**
     * Create multiple product configuration objects
     * @param array $ids
     * @return array Dvelum_Shop_Product_Config  [id => Dvelum_Shop_Product_Config]
     * @throws Exception
     */
    static public function factoryMultiple(array $ids)
    {
        if(!static::$initialized){
            static::init();
        }

        $result = [];

        foreach ($ids as $index => $id){
            if(isset(static::$instances[$id])){
                $result[$id] =  static::$instances[$id];
                unset($ids[$index]);
            }
        }

        if(!empty($ids)){
            $model = Model::factory(static::$config['object']);
            $data = $model->getItems($ids);
            if(!empty($data)){
                $data = Utils::rekey($model->getPrimaryKey(),$data);
            }
            foreach ($ids as $id){
                if(!isset($data[$id])){
                    throw new Exception('Undefined product '.$id);
                }
                $result[$id] = new static();
                $result[$id]->load($id,$data[$id]);
                static::$instances[$id] = $result[$id];
            }
        }
        return $result;
    }

    static protected function init()
    {
        $config = Config::storage()->get('dvelum_shop.php')->get('product_config');
        $systemFields = Config::storage()->get('dvelum_shop_fields.php')->__toArray();
        $appConfig = Config::storage()->get('main.php');

        $config['fields'] = $systemFields;
        
        Lang::addDictionaryLoader($config['lang'], $appConfig->get('language').'/'. $config['lang'].'.php', Config::File_Array);

        static::$lang = Lang::lang($config['lang']);
        static::$config = $config;
        static::$initialized = true;
    }

    /**
     * Dvelum_Shop_Product_Config constructor.
     */
    protected function __construct()
    {
        $this->model = Model::factory(static::$config['object']);
    }

    /**
     * Load product configuration
     * @param $id
     * @param null $data
     * @throws Exception
     */
    protected function load($id, $data = null)
    {
        $this->id = $id;

        if(!empty($data)){
            $this->data = $data;
        }elsE{
            $this->data = $this->model->getItem($id);

            if(empty($this->data)){
                throw new Exception('Undefined Product '.$id);
            }
        }

        $fields = json_decode($this->data['fields'],true);

        if(empty($fields)){
            $fields = [];
        }

        $this->data['fields'] = $this->initFields($fields);
    }
    /**
     * Initialize product fields
     * @param array $data
     * @return array
     */
    protected function initFields(array $data)
    {
        $data = array_merge($data , static::$config['fields']);

        $result = [];

        foreach ($data as $fieldConfig)
        {
            $name = $fieldConfig['name'];

            if(isset($fieldConfig['lazyLang']) && $fieldConfig['lazyLang']){
                $fieldConfig['title'] = static::$lang->get($fieldConfig['title']);
            }
            $fieldClass = 'Dvelum_Shop_Product_Field';
            $adapterClass = 'Dvelum_Shop_Product_Field_'.ucfirst($fieldConfig['type']);

            if(class_exists($adapterClass)){
                $fieldClass = $adapterClass;
            }
            $result[$name] = new $fieldClass($fieldConfig);
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

    /**
     * Get fields configuration as array
     * @return array
     */
    public function getFieldsConfig()
    {
        foreach ($this->data['fields'] as $name=>$field){
            $result[$name] = $field->__toArray();
        }
        return $result;
    }

    /**
     * Check if product field exists
     * @param $field
     * @return bool
     */
    public function fieldExist($field)
    {
        return isset($this->data['fields'][$field]);
    }

    /**
     * Get field object by name
     * @param string $name
     * @return Dvelum_Shop_Product_Field
     */
    public function getField($name)
    {
        return $this->data['fields'][$name];
    }
}