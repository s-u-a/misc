#!/usr/bin/php
<?php
	if($argc < 2)
	{
		fputs(STDERR, "Usage: ".$argv[0]." <database directory> <e-mail address>\n");
		exit(1);
	}

	$dir = $argv[1]."/players";
	if(!is_dir($dir))
	{
		fputs(STDERR, "Error: ".$dir." not found or not a directory.\n");
		exit(1);
	}

	$dh = opendir($dir);
	while(($fname = readdir($dh)) !== false)
	{
		if($fname == "." || $fname == "..") continue;

		$location = $dir."/".$fname;
		if(!is_file($location)) continue;
		if(!is_readable($location)) fputs(STDERR, "Warning: could not read ".$location."\n");

		$arr = unserialize(bzdecompress(file_get_contents($location)));
		if(!isset($arr['email'])) $arr['email'] = '';
		if(trim($arr['email']) == trim($argv[2]))
			fputs(STDOUT, urldecode($fname)."\n");
	}
	closedir($dh);
?>
