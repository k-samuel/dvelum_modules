<?php
class Dvelum_Backend_Articles_Installer extends Externals_Installer
{
    /**
     * Install
     * @param Config_Abstract $applicationConfig
     * @param Config_Abstract $moduleConfig
     * @return boolean
     */
    public function install(Config_Abstract $applicationConfig, Config_Abstract $moduleConfig)
    {
        Lang::addDictionaryLoader('dvelum_articles', $applicationConfig->get('language').'/dvelum_articles.php', Config::File_Array);
        $userId = User::getInstance()->getId();
        $lang = Lang::lang('dvelum_articles');

        $pagesModel = Model::factory('Page');
        $pageItem = $pagesModel->getList(false,['func_code' => 'dvelum_articles']);

        if(empty($pageItem))
        {
            try{
                $articlesPage = new Db_Object('Page');
                $articlesPage->setValues(array(
                    'code'=>'articles',
                    'is_fixed'=>1,
                    'html_title'=>$lang->get('articles'),
                    'menu_title'=>$lang->get('articles'),
                    'page_title'=>$lang->get('articles'),
                    'meta_keywords'=>'',
                    'meta_description'=>'',
                    'parent_id'=>null,
                    'text' =>'',
                    'func_code'=>'dvelum_articles',
                    'order_no' => 1,
                    'show_blocks'=>true,
                    'published'=>false,
                    'published_version'=>0,
                    'editor_id'=>$userId,
                    'date_created'=>date('Y-m-d H:i:s'),
                    'date_updated'=>date('Y-m-d H:i:s'),
                    'author_id'=>$userId,
                    'blocks'=>'',
                    'theme'=>'default',
                    'date_published'=>date('Y-m-d H:i:s'),
                    'in_site_map'=>true,
                    'default_blocks'=>true
                ));

                if(!$articlesPage->saveVersion(true, false))
                    throw new Exception('Cannot create articles page');

                if(!$articlesPage->publish())
                    throw new Exception('Cannot publish articles page');

            }catch (Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
            $articlesPageId = $articlesPage->getId();
        }else{
            $articlesPageItem = $pageItem[0];
            $articlesPageId = $articlesPageItem['id'];
        }

        $pageItem = $pagesModel->getList(false,['func_code' => 'dvelum_articles_item']);;
        if(empty($pageItem))
        {
            try{
                $page = new Db_Object('Page');
                $page->setValues(array(
                    'code'=>'article',
                    'is_fixed'=>1,
                    'html_title'=>$lang->get('article_page'),
                    'menu_title'=>$lang->get('article_page'),
                    'page_title'=>$lang->get('article_page'),
                    'meta_keywords'=>'',
                    'meta_description'=>'',
                    'parent_id'=>$articlesPageId,
                    'text' =>'',
                    'func_code'=>'dvelum_articles_item',
                    'order_no' => 1,
                    'show_blocks'=>true,
                    'published'=>false,
                    'published_version'=>0,
                    'editor_id'=>$userId,
                    'date_created'=>date('Y-m-d H:i:s'),
                    'date_updated'=>date('Y-m-d H:i:s'),
                    'author_id'=>$userId,
                    'blocks'=>'',
                    'theme'=>'default',
                    'date_published'=>date('Y-m-d H:i:s'),
                    'in_site_map'=>true,
                    'default_blocks'=>true
                ));

                if(!$page->saveVersion(true, false))
                    throw new Exception('Cannot create article page');

                if(!$page->publish())
                    throw new Exception('Cannot publish article page');

            }catch (Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }

        // Add permissions
        $userInfo = User::getInstance()->getInfo();
        $permissionsModel = Model::factory('Permissions');
        if(!$permissionsModel->setGroupPermissions($userInfo['group_id'], 'Dvelum_Articles' , 1 , 1 , 1 , 1)){
            return false;
        }
        if(!$permissionsModel->setGroupPermissions($userInfo['group_id'], 'Dvelum_Articles_Category' , 1 , 1 , 1 , 1)){
            return false;
        }
    }

    /**
     * Uninstall
     * @param Config_Abstract $applicationConfig
     * @param Config_Abstract $moduleConfig
     * @return boolean
     */
    public function uninstall(Config_Abstract $applicationConfig, Config_Abstract $moduleConfig)
    {
        $pagesModel = Model::factory('Page');
        $pageItems = $pagesModel->getList(false,['func_code' => 'dvelum_articles']);

        foreach($pageItems as $item)
        {
            try{
                $page = Db_Object::factory('Page', $item['id']);
                $page->unpublish();
            }catch (Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }

        $pageItems = $pagesModel->getList(false,['func_code' => 'dvelum_articles_item']);
        foreach($pageItems as $item)
        {
            try{
                $page = Db_Object::factory('Page', $item['id']);
                $page->unpublish();
            }catch (Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }
    }
}