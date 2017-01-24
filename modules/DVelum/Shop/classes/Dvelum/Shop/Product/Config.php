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

    static public function init()
    {
        $config = Config::storage()->get('dvelum_shop.php')->get('product_config');
        $systemFields = Config::storage()->get('dvelum_shop_fields.php')->__toArray();
        $systemGroups = Config::storage()->get('dvelum_shop_field_groups.php')->__toArray();
        $appConfig = Config::storage()->get('main.php');

        $config['fields'] = $systemFields;
        $config['groups'] = $systemGroups;
        
        Lang::addDictionaryLoader($config['lang'], $appConfig->get('language').'/'. $config['lang'].'.php', Config::File_Array);

        static::$lang = Lang::lang($config['lang']);
        static::$config = $config;
        static::$initialized = true;
    }
    /**
     * Get list of system fields
     * @return array
     */
    static public function getSystemFields()
    {
        return static::$config['fields'];
    }

    /**
     * Get list of system groups
     * @return array
     */
    static public function getSystemGroups()
    {
        return static::$config['groups'];
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

        if(!empty($this->data['groups'])){
            $groups = json_decode($this->data['groups'],true);
        }

        if(empty($groups)){
            $groups = [];
        }
        $this->data['groups'] = $this->initGroups($groups);
    }
    /**
     * Initialize product fields
     * @param array $data
     * @return array
     */
    protected function initFields(array $data)
    {
        if(!empty($data)){
            $data = array_merge(static::$config['fields'], $data);
        }else{
            $data = static::$config['fields'];
        }

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

            if(!isset($fieldConfig['multivalue'])){
                $fieldConfig['multivalue'] = false;
            }

            $result[$name] = new $fieldClass($fieldConfig);
        }
        return $result;
    }

    /**
     * Initialize product field groups
     * @param array $groups
     * @return array
     */
    protected function initGroups(array $groups)
    {
        if(!empty($groups)){
            $data = array_merge(static::$config['groups'], $groups);
        }else{
            $data = static::$config['groups'];
        }

        $result = [];

        foreach ($data as &$config)
        {
            if(isset($config['lazyLang']) && $config['lazyLang']){
                $config['title'] = static::$lang->get($config['title']);
            }
            $result[$config['code']] = $config;
        }unset($config);

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
     * Get field grups configuration as array
     * @return array
     */
    public function getGroupsConfig()
    {
        return $this->data['groups'];
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

    /**
     * Get product fields
     * @return Dvelum_Shop_Product_Field[]
     */
    public function getFields()
    {
        return $this->data['fields'];
    }
}