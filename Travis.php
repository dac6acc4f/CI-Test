<?php
$server = proc_open(PHP_BINARY . " src/pocketmine/PocketMine.php --no-wizard --disable-readline", [
	0 => ["pipe", "r"],
	1 => ["pipe", "w"],
	2 => ["pipe", "w"]
], $pipes);

fwrite($pipes[0], "version\nmakeserver\nstop\n\n");

while(!feof($pipes[1])){
	echo fgets($pipes[1]);
}

fclose($pipes[0]);
fclose($pipes[1]);
fclose($pipes[2]);

echo "\n\nReturn value: ". proc_close($server) ."\n";

if(count(glob("plugins/DevTools/ClearSky*.phar")) === 0){
	echo "No server phar created!\n";
	exit(1);
}else{
    $buildID = "";
	echo "Server phar created!\n";
    echo "Uploading to GitHub";
    echo exec("mkdir travis_builds"); //in case you don't want to have a messy repo ;-)
    echo exec("git add plugins/DevTools/ClearSky*.phar");
    echo exec("git commit -m 'Travis CI auto build'". $buildID); //you may want to add the current version here
    echo exec("git push php7"); //or some other branches
	exit(0);
}
