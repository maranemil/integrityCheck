<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 21.01.15
 * Time: 16:27
 */

$manifest = array(
	'acceptable_sugar_versions' =>
		array(
			"regex_matches" => array(
				"6.5.*",
				"7.2.*",
				"7.5.*"
			)
		),
	array(
		'acceptable_sugar_flavors' =>
			array(
				'CE',
				'PRO',
				'CORP',
				'ENT',
				'ULT',
			),
	),
	'readme'                    => 'Integrity Check Module',
	'key'                       => 'IntegrityCheckModule',
	'author'                    => 'Emil Maran',
	'description'               => 'Integrity Check Module',
	'icon'                      => '',
	'is_uninstallable'          => true,
	'name'                      => 'Integrity Check Module',
	'published_date'            => '2015-01-21 15:08:02',
	'type'                      => 'module',
	'version'                   => '0.1',
	'remove_tables'             => 'prompt',
);

$installdefs = array(
	'id'             => 'IntegrityCheckModule_1421854167',
	'copy'           =>
		array(

		   /**
			*
			*/

		   /*  Copy Include
		   --------------------------------------------*/

		   array(
			   'from' => '<basepath>/custom/clients/base/api/',
			   'to'   => 'custom/clients/base/api/',
		   ),
		),
	'pre_execute'    =>
		array(
			0 => '<basepath>/pre_execute/0.php',
		),
	'post_uninstall' =>
		array(
			0 => '<basepath>/post_uninstall/0.php',
		),

	/*
	'custom_fields' => array(
		array(
			'name' => 'ceteam_id_c' ,
			'label' => 'Team ID' ,
			'type' => 'varchar' ,
			'max_size' => 36 ,
			'required' => false ,
			'require_option' => 'optional' ,
			'default_value' => '1' ,
			'ext1' => '' ,
			'ext2' => '' ,
			'ext3' => '' ,
			'audited' => 0 ,
			'module' => 'Accounts'
		) ,
		array(
			'name' => 'ceteam_id_c' ,
			'label' => 'Team ID' ,
			'type' => 'varchar' ,
			'max_size' => 36 ,
			'required' => false ,
			'require_option' => 'optional' ,
			'default_value' => '1' ,
			'ext1' => '' ,
			'ext2' => '' ,
			'ext3' => '' ,
			'audited' => 0 ,
			'module' => 'Bugs'
		) ,
	)*/
);
