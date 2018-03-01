<?php
<<<<<<< HEAD
	
	return [
		
		/*
		|--------------------------------------------------------------------------
		| Laravel CORS
		|--------------------------------------------------------------------------
		|
		| allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
		| to accept any value.
		|
		*/
		
		'supportsCredentials'    => false,
		'allowedOrigins'         => ['*'],
		'allowedOriginsPatterns' => [],
		'allowedHeaders'         => ['*'],
		'allowedMethods'         => ['*'],
		'exposedHeaders'         => [],
		'maxAge'                 => 0,
	
	];
=======

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    'exposedHeaders' => ['Authorization'],
    'maxAge' => 0,

];
>>>>>>> 6f49bb669cc3a9c09f958f246d9fd8ff2e9a4747
