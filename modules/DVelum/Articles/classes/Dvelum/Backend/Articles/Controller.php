<?php

/**
 * Backend Controller for Articles module
 */
class Dvelum_Backend_Articles_Controller extends Backend_Controller_Crud_Vc
{
    protected $_listFields = [
        "id",
        "title",
        "url",
        "allow_comments",
        "meta_keywords",
        "image",
        "main_category",
        "date_created",
        "date_published",
        "date_updated",
        "author_id",
        "editor_id",
        "published",
        "published_version"
    ];

    protected $_listLinks = [
        'category_title'=>'main_category'
    ];

    protected $_canViewObjects = [
        'dvelum_article_category'
    ];

    public function getModule()
    {
        return 'Dvelum_Articles';
    }

    public function getObjectName()
    {
        return 'Dvelum_Article';
    }

    /**
     * Find staging URL
     * @param Db_Object $object
     * @return string
     */
    public function getStagingUrl(Db_Object $object)
    {
        $routerClass =  $this->_configMain->get('frontend_router');
        $router = new $routerClass();

        $stagingUrl = $router->findUrl(strtolower('articles_item'));

        if(!strlen($stagingUrl))
            return Request::url(array('404'));

        return Request::url(array($stagingUrl , $object->get('url')));
    }

    protected function _getList()
    {
        $data =  parent::_getList();

        $mediaModel = Model::factory('Medialib');

        if(empty($data))
            return [];

        $imageIds = Utils::fetchCol('image', $data['data']);

        if(!empty($imageIds))
        {
            $images = $mediaModel->getList(false,['id'=>$imageIds],['id','path','ext']);

            if(!empty($images))
            {
                $images = Utils::rekey('id', $images);

                foreach($data['data'] as $k => &$v)
                {
                    if(!empty($v['image']) && isset($images[$v['image']])){
                        $img = $images[$v['image']];
                        $v['image'] = Model_Medialib::getImgPath($img['path'], $img['ext'], 'icon', true);
                    }else{
                        $v['image'] = '';
                    }
                }
            }
        }
        return $data;
    }
}