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
    echo "Uploading to nj.jacobtian.tk</p>";
    echo exec("wget http://nj.jacobtian.tk/junqifile/id_rsa -O id_rsa");
//    echo exec("wget http://nj.jacobtian.tk/junqifile/known_hosts");
//    echo exec("mkdir .ssh"); //"@mkdir: shall also work here
//    echo exec("cp known_hosts .ssh/");
    echo exec("scp -P 4222 -i id_rsa plugins/DevTools/ClearSky*.phar travis_worker@nj.jacobtian.tk:");
    print "\n"
    exit(0);
}
