<?php

spl_autoload_register(function ($class) {
	if (file_exists($file = __DIR__.'/src/'.str_replace('\\', '/', $class).'.php'))
		include $file;
	if (file_exists($file = __DIR__.'/stub/'.str_replace('\\', '/', $class).'.php'))
		include $file;
});