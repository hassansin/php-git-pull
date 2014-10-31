<?php
$private_key_file = "/var/www/id_rsa";
$ssh_user = "root";
$git_repo_path = "/var/www/html";
$git_repo_passphrase = "your_passphrase";


require(__DIR__.'/vendor/autoload.php');
$ssh = new Net_SSH2('vps.reviewing.net');
$key = new Crypt_RSA();
$key->loadKey(file_get_contents('/var/www/id_rsa'));
if (!$ssh->login('root', $key)) {
    exit('Login Failed');
}
$ssh->setTimeout(20);     
echo '<pre>';     
echo $ssh->read('');    
$ssh->write("cd $git_repo_path && git pull origin master\n");    
$ssh->read('Enter passphrase');
$ssh->write("$git_repo_passphrase\n");
echo $ssh->read('');
//$ssh->write("cd .. && chown -R www-data:www-data html\n");
//echo $ssh->read('');

?>