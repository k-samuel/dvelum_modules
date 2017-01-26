<?php
/**
 *  DVelum project http://dvelum.net, http://dvelum.ru, https://github.com/k-samuel/dvelum
 *  Copyright (C) 2011-2017  Kirill Yegorov
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class Dvelum_Shop_Image_Medialib extends Dvelum_Shop_Image_AbstractAdapter
{
    /**
     * Files path
     * @var string $storagePath
     */
    protected $storagePath;
    /**
     * Media-library model
     * @var Model_Medialib $mediaModel
     */
    protected $mediaModel;

    /**
     * Path to images
     * @var string $wwwPath
     */
    protected $wwwPath;

    /**
     * File uploader configuration
     * @var array
     */
    protected $uploaderConfig = [];

    public function __construct(Config_Abstract $config)
    {
        parent::__construct($config);
        $appConfig = Config::storage()->get('main.php');
        $this->storagePath = $appConfig->get('uploads') . $this->config->get('file_path');
        $this->mediaModel = Model::factory('Medialib');
        $this->wwwPath = $appConfig->get('wwwpath');
        $this->uploaderConfig = ['image'=>Config::storage()->get('media_library.php')->get('image')];
    }

    /**
     * Add image
     * @param $path
     * @param array $info
     * @return integer|boolean - Image ID
     */
    public function addImage($path, array $info)
    {
        $uploader = new Upload($this->uploaderConfig);

        $files = [[
            'name'=> basename($path),
            'tmp_name'=> $path,
            'type'=> '',
            'size'=> filesize($path),
            'error'=>false
        ]];

        $hash = md5_file($path);

        $image = $this->mediaModel->getList(['start'=>0,'limit'=>1],['hash'=>$hash]);

        if(!empty($image)){
            return $image[0]['id'];

        }

        $uploadDir = $this->storagePath. date('Y') . '/' . date('m') . '/' . date('d') . '/' . User::getInstance()->getId().'/';

        if(!is_dir($uploadDir) && !mkdir($uploadDir,0755,true)){
            $this->mediaModel->logError('Cannot create dir '. $uploadDir);
            return false;
        }

        $uploadResult = $uploader->start($files, $uploadDir, false);

        if(empty($uploadResult) || !isset($uploadResult[0])) {
            $errors = implode(', ', $uploader->getErrors());
            $this->mediaModel->logError($errors);
            return false;
        }

        $fileInfo = $uploadResult[0];

        $filePath = str_replace($this->wwwPath, '/' , $fileInfo['path']);

        if(isset($info['title'])){
            $fileInfo['title'] = $info['title'];
        }

        return $this->mediaModel->addItem(
            $fileInfo['title'] ,
            $filePath ,
            $fileInfo['size'] ,
            $fileInfo['type'] ,
            $fileInfo['ext'] ,
            $this->config->get('category'),
            $hash
        );
    }

    /**
     * Delete image
     * @param $id
     * @return boolean
     */
    public function deleteImage($id)
    {
        return $this->mediaModel->remove($id);
    }

    /**
     * Get image info
     * @param $id
     * @return array
     */
    public function getImage($id)
    {
        return $this->mediaModel->getItem($id);
    }
}