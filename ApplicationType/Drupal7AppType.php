<?php

namespace DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\ApplicationType;

use DigipolisGent\Domainator9k\CoreBundle\Entity\BaseAppType;
use DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Entity\DrupalSevenSettings;
use DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Form\DrupalSevenSettingsType;
use Digip\DeployBundle\Entity\Settings;
use Digip\DeployBundle\Entity\AppEnvironment;

class Drupal7AppType extends BaseAppType
{
    protected $settingsFormClass = DrupalSevenSettingsType::class;
    protected $settingsEntityClass = DrupalSevenSettings::class;

    public function getConfigFiles(AppEnvironment $env, array $servers, Settings $settings)
    {
        $user = $env->getServerSettings()->getUser();

        $dbName = $env->getDatabaseSettings()->getName();
        $dbUser = $env->getDatabaseSettings()->getUser();
        $dbPass = $env->getDatabaseSettings()->getPassword();
        $dbHost = $env->getDatabaseSettings()->getHost();
        $redisPass = $settings->getAppEnvironmentSettings($env)->getRedisPassword();
        $config = $this->getSiteConfig();
        $appFolder = $env->getApplication()->getNameForFolder();
        $appName = $env->getApplication()->getNameCanonical();
        $salt = $env->getSalt();

        $content = <<<SETTINGS
<?php
\$databases = array (
  'default' =>
  array (
	'default' =>
	array (
	  'database' => '$dbName',
	  'username' => '$dbUser',
	  'password' => '$dbPass',
	  'host' => '$dbHost',
	  'port' => '',
	  'driver' => 'mysql',
	  'prefix' => '',
	),
  ),
);
\$drupal_hash_salt = '$salt';
\$conf['file_public_path'] = 'sites/default/files';
\$conf['file_private_path'] = '/home/$user/apps/$appFolder/files/private';
\$conf['file_temporary_path'] = '/home/$user/apps/$appFolder/files/tmp';
if (file_exists('sites/all/modules/contrib/redis/redis.autoload.inc') && !file_exists('/var/run/redis/redis_isnotavailable')) {
  \$conf['redis_client_interface']  = 'PhpRedis';
  \$conf['redis_client_host']       = '127.0.0.1';
  \$conf['redis_client_port']       = 6380;
  \$conf['lock_inc']                = 'sites/all/modules/contrib/redis/redis.lock.inc';
  \$conf['cache_backends'][]        = 'sites/all/modules/contrib/redis/redis.autoload.inc';
  \$conf['cache_default_class']     = 'Redis_Cache';
  \$conf['cache_prefix'] 	        = '$appName';
  \$conf['redis_client_password']   = '$redisPass';
  \$conf['cache_class_cache_form']  = 'DrupalDatabaseCache';
  \$conf['redis_client_timeout']    = 2;
  \$conf['redis_client_reserved']   = NULL;
  \$conf['redis_client_retry_interval'] = 200;
}
if (file_exists('profiles/digipolis/modules/contrib/redis/redis.autoload.inc') && !file_exists('/var/run/redis/redis_isnotavailable')) {
  \$conf['redis_client_interface']  = 'PhpRedis';
  \$conf['redis_client_host']       = '127.0.0.1';
  \$conf['redis_client_port']       = 6380;
  \$conf['lock_inc']                = 'profiles/digipolis/modules/contrib/redis/redis.lock.inc';
  \$conf['cache_backends'][]        = 'profiles/digipolis/modules/contrib/redis/redis.autoload.inc';
  \$conf['cache_default_class']     = 'Redis_Cache';
  \$conf['cache_prefix'] 	        = '$appName';
  \$conf['redis_client_password']   = '$redisPass';
  \$conf['cache_class_cache_form']  = 'DrupalDatabaseCache';
  \$conf['redis_client_timeout']    = 2;
  \$conf['redis_client_reserved']   = NULL;
  \$conf['redis_client_retry_interval'] = 200;
}
$config
SETTINGS;

        $content = $env->replaceConfigPlaceholders($content);
        $files = array(
            '/dist/'.$user.'/'.$appFolder.'/config/settings.php' => $content,
        );

        $aliases = '<?php';
        $environments = $this->getEnvironmentService()->getEnvironments();

        foreach ($environments as $environment) {
            // TODO: This shouldn't be necessary. Probably because a Filesystem init only gets env servers, this is otherwise empty for "remote envs"
            $ip = '';

            foreach ($servers as $server) {
                if ($server->isTaskServer() && $server->getEnvironment() === $environment) {
                    $ip = $server->getIp();
                    break;
                }
            }

            $uri = $env->getApplication()->getAppEnvironment($environment)->getPreferredDomain();

            if ($this->getName() === $environment) {
                $aliases .= <<<ALIAS

\$aliases['$environment'] = array(
    'uri' => '$uri',
    'root' => '/home/$user/apps/$appFolder/current',
);
ALIAS;
            } else {
                $aliases .= <<<ALIAS

\$aliases['$environment'] = array(
    'uri' => '$uri',
    'root' => '/home/$user/apps/$appFolder/current',
    'remote-host' => '$ip',
    'remote-user' => '$user',
);
ALIAS;
            }

            $files['/home/'.$user.'/.drush/'.(($appFolder !== 'default') ? $appFolder : $this->getName()).'.aliases.drushrc.php'] = $aliases;
        }

        return $files;
    }
}
