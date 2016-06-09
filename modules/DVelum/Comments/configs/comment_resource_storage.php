<?php
return array(
		'development' =>
				array(
						'adapter'=>'Orm',
						'filepath' => './www/media/uploads',
						'object'=>'dvelum_coomment_resource',
						'check_orm_structure'=> false,
						'user_id'=>0, //default user ID
						'upload_prefix'=>'',
						'rename'=>true,
						'uploader' => 'Upload',
						'uploader_config' => array(
								'file' => array(
										'title' => 'Files' ,
										'extensions' => array(
												'.gif' ,
												'.png' ,
												'.jpg' ,
												'.jpeg'
										)
								)
						),
						'download'=>array(
								'type'=> 'native', // native / apache / nginx
								'redirect_path' => ''
						)
				),
		'production' => array(
				'adapter'=>'Orm',
				'filepath' => './www/media/uploads',
				'object'=>'dvelum_coomment_resource',
				'check_orm_structure'=> false,
				'user_id'=>0, //default user ID
				'upload_prefix'=>'',
				'rename'=>true,
				'uploader' => 'Upload',
				'uploader_config' => array(
						'file' => array(
								'title' => 'Files' ,
								'extensions' => array(
										'.gif' ,
										'.png' ,
										'.jpg' ,
										'.jpeg'
								)
						)
				),
				'download'=>array(
						'type'=> 'native', // native / apache / nginx
						'redirect_path' => ''
				)
		),
);