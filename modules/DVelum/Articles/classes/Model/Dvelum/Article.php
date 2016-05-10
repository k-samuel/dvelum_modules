<?php
class Model_Dvelum_Article extends Model
{
    /**
     * Article fields for lists
     * @var array
     */
    protected $topListFields = [
        'id',
        'main_category',
        'url',
        'title',
        'brief',
        'image',
        'date_published'
    ];

    /**
     * Get previous articles from category
     * @param integer $articleId
     * @param integer $categoryId
     * @param string $dataPublished
     * @param integer $count
     * @return array
     */
    public function getRelated($articleId, $categoryId, $dataPublished, $count)
    {
        $cacheKey =  $this->getCacheKey([
            'related_articles',
             $articleId,
        ]);

        $data = false;

        if($this->_cache){
            $data = $this->_cache->load($cacheKey);
        }

        if($data !==false)
            return $data;

        $sql = $this->_db->select()->from(
                $this->table(),
                $this->topListFields
            )
            ->where('main_category =?', $categoryId)
            ->where('date_published < ?', $dataPublished)
            ->where('id !=?',$articleId)
            ->where('published = 1')
            ->order('date_published DESC')
            ->limit($count);

        $data = $this->_db->fetchAll($sql);

        if($this->_cache)
            $this->_cache->save($data , $cacheKey);

        return $data;
    }

    /**
     * Get image path to result set
     * @param array $data
     * @param string $imageSize - size name from media library config
     * @param string $key - array key for image path
     * @return array
     */
    public function addImagePaths($data, $imageSize, $key = 'image')
    {
        if(empty($data)){
            return [];
        }

        $mediaModel = Model::factory('Medialib');
        $imageIds = Utils::fetchCol('image', $data);

        if(!empty($imageIds))
        {
            $images = $mediaModel->getList(false,['id'=>$imageIds],['id','path','ext']);

            if(!empty($images))
            {
                $images = Utils::rekey('id', $images);

                foreach($data as $k => &$v)
                {
                    if(!empty($v['image']) && isset($images[$v['image']])){
                        $img = $images[$v['image']];
                        $v[$key] = Model_Medialib::getImgPath($img['path'], $img['ext'], $imageSize, true);
                    }else{
                        $v[$key] = '';
                    }
                }
            }
        }
        return $data;
    }


    /**
     * Cet count of published articles
     * @param integer | boolean $category, default false
     * @return bool|integer
     */
    public function getPublishedCount($category = false)
    {
        $data = false;

        if($this->_cache){
            $key = $this->getCacheKey(['articles_published', $category]);
            $data = $this->_cache->load($key);
        }

        if(!empty($data)){
            return $data;
        }

        $filters = array(
            'published' => 1,
        );

        if($category){
            $filters['main_category']= $category;
        }

        $count = $this->getCount($filters);

        if($this->_cache)
            $this->_cache->save($count , $key);

        return $count;
    }

    /**
     * Reset related articles cache
     * @param $articleId
     */
    public function resetRelatedCache($articleId)
    {
        if(!$this->_cache)
            return;

        $cacheKey =  $this->getCacheKey([
            'related_articles',
            $articleId,
        ]);

        $this->_cache->remove($cacheKey);
    }

    /**
     * Reset latest articles cache
     * @param $category, optional default false
     */
    public function resetTopCache($category)
    {
        if(!$this->_cache)
            return;

        $this->_cache->remove($this->getCacheKey(array('top_100', intval($category))));
    }

    /**
     * Reset cache of published counter
     * @param integer | boolean $category, default false
     */
    public function resetPublishedCount($category = false)
    {
        if($this->_cache){
            $key = $this->getCacheKey(['articles_published', $category]);
            $this->_cache->remove($key);
        }
    }

    /**
     * Get list of top articles
     * @param integer|boolean $categoryId
     * @param integer $count
     * @param integer $offset
     * @param string $imageSize
     * @return array
     */
    public function getTop($categoryId = false, $count = 10 , $offset = 0, $imageSize = 'thumbnail')
    {
        $pager = [
            'sort'=>'date_published',
            'dir'=>'DESC',
            'start' =>$offset,
            'limit' =>$count
        ];

        $filter = array(
            'published' => true
        );

        if($categoryId) {
            $filter['main_category'] = $categoryId;
        }

        /*
         * Get from cache
         */
        if($this->_cache && (($offset + $count) < 100)){
            $data = array_slice($this->getTop100($categoryId, $imageSize), $offset , $count);
        }else{
            $data = $this->getList($pager , $filter, $this->topListFields);
            if(!empty($data)) {
                $data = $this->addImagePaths($data, $imageSize, 'image');
            }
        }
        return $data;
    }

    /**
     * Get top 100 Articles
     * @param integer|boolean $category
     * @param string $imageSize
     * @return array
     */
    public function getTop100($category = false, $imageSize = 'thumbnail')
    {
        $data = false;

        if($this->_cache){
            $hash = $this->getCacheKey(array('top_100' , intval($category)));
            $data = $this->_cache->load($hash);
        }

        if($data !==false)
            return $data;

        $pager = array(
            'sort'=>'date_published',
            'dir'=>'DESC',
            'start' =>0,
            'limit' =>100
        );

        $filter = array(
            'published' => true,
        );

        if($category)
            $filter['main_category'] = $category;

        $data = $this->getList($pager , $filter, $this->topListFields);

        $images = array();

        if(!empty($data)) {
            $data =  $this->addImagePaths($data, $imageSize, 'image');
        }

        if($this->_cache)
            $this->_cache->save($data , $hash);

        return $data;
    }

}