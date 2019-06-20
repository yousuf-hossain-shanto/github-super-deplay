<?php
set_time_limit(300);
$username='yousuf-hossain-shanto';
$password='TWRzaGFudG83MjcwOTY=';
$reponame='VidMe';
$branch='master';
$working_dir='../Shanto';
$URL="https://github.com/$username/$reponame/archive/$branch.zip";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'https://github.com');
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$username:" . base64_decode($password));

curl_setopt($ch, CURLOPT_URL,$URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$file_name = $reponame . '.zip';

$result=curl_exec($ch);
$info = curl_getinfo($ch);
curl_close ($ch);


file_put_contents($file_name, $result);

//var_dump($info);

if ($info['http_code'] == 200 && file_exists($file_name)) {

    // get the absolute path to $file
    $path = pathinfo(realpath($file_name), PATHINFO_DIRNAME);
    $extract_folder_name = $path . '/' . $reponame . '-' . $branch;
    $composer = realpath('./composer.phar');

    $zip = new ZipArchive;
    $res = $zip->open($file_name);
    if ($res === TRUE) {
        $zip->extractTo($path);
        $zip->close();
        if (is_dir($extract_folder_name)) {
            rename($extract_folder_name, $working_dir);
            @unlink($file_name);
            exec("cd $working_dir;php $composer install --no-interaction", $out);
            var_dump($out);
        }
    } else {
        echo "Doh! I couldn't open $file_name";
    }

}