<?php
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../'));
define('APPLICATION_TEST_PATH', realpath(dirname(__FILE__)));


/* In Linux' ( and probably OS X') php 5.3.10 (might exist in later versions)
 * spl_autoloading doesn't replace folder separator. This is a fix for this.
*/
spl_autoload_register('spl_autoload');
spl_autoload_register(function ($class) {
	$ver = explode('-',phpversion());
	if (0 >= strcmp($ver[0],'5.3.10') && 0 == strcmp('Linux', php_uname('s'))) {
		$class  =  implode( DIRECTORY_SEPARATOR , explode( '\\' , $class ) );
		static $extensions  =  array();
		if ( empty($extensions ) )
			{
				$extensions  =  array_map( 'trim' , explode( ',' , spl_autoload_extensions() ) );
			}
			static $include_paths  =  array();
			if ( empty( $include_paths ) )
				{
					$include_paths  =  explode( PATH_SEPARATOR , get_include_path() );
				}
				foreach ( $include_paths as $path )
					{
						$path .=  ( DIRECTORY_SEPARATOR !== $path[ strlen( $path ) - 1 ] ) ? DIRECTORY_SEPARATOR : '';
						foreach ( $extensions as $extension )
							{
						$file  =  $path . $class . $extension;
						if ( file_exists( $file ) && is_readable( $file ) )
								{
							require $file;
							return;
						}
					}
				}
				throw new \Exception( _( 'class ' . $class . ' could not be found.' ) );
			}
		});
/* use if you need to lowercase first char *
 $class  =  implode( DIRECTORY_SEPARATOR , array_map( 'lcfirst' , explode( '\\' , $class ) ) );/* else just use the following : */

// spl_autoload_register(function($sClas) {
// 	$nClass = str_replace("\\", "/", $sClas);
// 	require_once APPLICATION_PATH . '/' . $nClass . ".php";
// });