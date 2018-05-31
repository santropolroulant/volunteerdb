<?php
namespace lib\Cake\Test\test_app\Config;

$config = array(
	'Read' => 'value',
	'Deep' => array(
		'Deeper' => array(
			'Deepest' => 'buried'
		)
	),
	'TestAcl' => array(
		'classname' => 'Original'
	)
);
