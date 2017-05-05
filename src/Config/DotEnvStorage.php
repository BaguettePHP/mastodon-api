<?php

namespace Baguette\Mastodon\Config;

use Baguette\Mastodon;
use Baguette\Mastodon\Service\Authorization;
use Baguette\Mastodon\Service\Scope;
use Respect\Validation\Validator as v;

/**
 * Mastodon config storage using PHP dotenv
 *
 * NOTICE: This class is designed for simple development use.
 * You should not use this for production environments or for batch processing.
 *
 * @see https://github.com/vlucas/phpdotenv
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class DotEnvStorage extends \Dotenv\Loader implements Storage
{
    use \Teto\Object\ReadOnly;

    /** @var string|resource */
    private $file_path;

    /** @var array */
    private $key_names = [
        'app_name'      => 'APP_NAME',
        'client_id'     => 'CLIENT_ID',
        'client_secret' => 'CLIENT_SECRET',
        'username'      => 'USERNAME',
        'password'      => 'PASSWORD',
        'access_token'  => 'ACCESS_TOKEN',
        'scope'         => 'SCOPE',
        'created_at'    => 'CREATED_AT',
    ];

    /** @var bool */
    private $read_only = true;

    /** @var array */
    private $save_values = [];

    /**
     * @param string $file_path
     * @param array  $options
     * @throws \Dotenv\Exception\InvalidPathException
     */
    public function __construct($file_path, $options = [])
    {
        $this->file_path = $file_path;

        if (isset($options['key_names'])) {
            $this->key_names = $options['key_names'] + $this->key_names;
        }

        if (isset($options['read_only'])) {
            v::boolType()->assert($options['read_only']);
            $this->read_only = $options['read_only'];
        }

        // ignore parent class constructor
        if (false) {
            parent::__construct($file_path);
        }
    }

    /**
     * @return array
     */
    public function getAppName()
    {
        $appname_key = $this->key_names['app_name'];

        $values = $this->getValues();

        return [
            'app_name' => isset($values[$appname_key]) ? $values[$appname_key] : null,
        ];
    }

    /**
     * @param  string $app_name
     * @return void
     */
    public function setAppName($app_name)
    {
        v::stringType()->not(v::contains("\n"))->assert($app_name);
        $this->save_values['app_name'] = $app_name;
    }

    /**
     * @return array
     */
    public function getAuthorization()
    {
        $token_key = $this->key_names['access_token'];
        $scope_key = $this->key_names['scope'];
        $cat_key   = $this->key_names['created_at'];

        $values = $this->getValues();

        return [
            'access_token' => isset($values[$token_key]) ? $values[$token_key] : null,
            'scope'        => isset($values[$scope_key]) ? $values[$scope_key] : null,
            'created_at'   => isset($values[$cat_key])   ? $values[$cat_key]   : null,
        ];
    }

    /**
     * @param  string                $access_token
     * @param  string|string[]|Scope $scope
     * @param  int                   $created_at
     * @return void
     */
    public function setAuthorization($access_token, $scope = null, $created_at = null)
    {
        v::stringType()->not(v::contains("\n"))->assert($access_token);
        v::intType()->min(0)->assert($created_at);
        $this->save_values['access_token'] = $access_token;
        $this->save_values['scope'] = (string)Mastodon\scope($scope);
        $this->save_values['created_at'] = $created_at;
    }

    /**
     * @param  Authorization $authorization
     * @return void
     */
    public function setAuthorizationFromObject(Authorization $authorization)
    {
        $this->setAuthorization(
            $authorization->access_token,
            $authorization->scope,
            $authorization->created_at->getTimestamp()
        );
    }

    /**
     * @Return array
     */
    public function getClientIdAndSecret()
    {
        $id_key  = $this->key_names['client_id'];
        $sec_key = $this->key_names['client_secret'];

        $values = $this->getValues();

        return [
            'client_id'     => isset($values[$id_key])  ? $values[$id_key]  : null,
            'client_secret' => isset($values[$sec_key]) ? $values[$sec_key] : null,
        ];
    }

    /**
     * @param  string $client_id
     * @param  string $client_secret
     */
    public function setClientIdAndSecret($client_id, $client_secret)
    {
        v::stringType()->not(v::contains("\n"))->assert($client_id);
        v::stringType()->not(v::contains("\n"))->assert($client_secret);
        $this->save_values['client_id']     = $client_id;
        $this->save_values['client_secret'] = $client_secret;
    }

    /**
     * @return array
     */
    public function getUsernameAndPassword()
    {
        $user_key = $this->key_names['username'];
        $pass_key = $this->key_names['password'];
        $values = $this->getValues();

        return [
            'username' => isset($values[$user_key]) ? $values[$user_key] : null,
            'password' => isset($values[$pass_key]) ? $values[$pass_key] : null,
        ];
    }

    /**
     * @param  string $username
     * @param  string $password
     */
    public function setUsernameAndPassword($username, $password)
    {
        v::stringType()->not(v::contains("\n"))->assert($username);
        v::stringType()->not(v::contains("\n"))->assert($password);
        $this->save_values['username']     = $username;
        $this->save_values['password'] = $password;
    }

    /**
     * Returns all stored key-value pairs
     *
     * @return array
     */
    public function getValues()
    {
        $values = [];

        foreach ($this->getLines() as $line) {
            if (!$this->isComment($line) && $this->looksLikeSetter($line)) {
                list($key, $val) = $this->normaliseEnvironmentVariable($line, '');
                $values[$key] = $val;
            }
        }

        return $values;
    }

    /**
     * @param  resource $fp
     * @return string[]
     */
    public function getLines($fp = null)
    {
        $fp = ($fp === null) ? $this->file_path : $fp;

        if (is_string($fp)) {
            return $this->readLinesFromFile($fp);
        }

        rewind($fp);

        return preg_split("/\r?\n/", stream_get_contents($fp));
    }

    /**
     * @return void
     */
    public function save()
    {
        if ($this->read_only) {
            throw new \RuntimeException('This config store is read only.');
        }

        $tbl = array_flip($this->key_names);

        $opend_file = false;
        if (is_string($this->file_path)) {
            $fp = fopen($this->file_path, 'rwb');
            $opend_file = true;
        } else {
            $fp = $this->file_path;
            rewind($fp);
        }

        $lines = $this->getLines($fp);
        $orig_lines = $lines;

        if ($opend_file) {
            fclose($fp);
        }

        foreach ($lines as $i => $line) {
            if ($this->isComment($line) || !$this->looksLikeSetter($line)) {
                continue;
            }

            list($key, $val) = $this->normaliseEnvironmentVariable($line, '');

            if (isset($tbl[$key]) && isset($this->save_values[$tbl[$key]])) {
                $saveval = $this->save_values[$tbl[$key]];
                $lines[$i] = sprintf('%s=%s', $key, $this->quoteValue($saveval));
                unset($this->save_values[$tbl[$key]]);
            }
        }

        foreach ($this->save_values as $key => $saveval) {
            $lines[] = sprintf('%s=%s', $this->key_names[$key], $this->quoteValue($saveval));
        }

        // noop
        if ($orig_lines === $lines) {
            return;
        }

        if ($opend_file) {
            file_put_contents($this->file_path, implode("\n", $lines) . "\n");
        } else {
            rewind($fp);
            fwrite($fp, implode("\n", $lines) . "\n");
        }
    }

    /**
     * @param string $value
     */
    public static function quoteValue($value)
    {
        return sprintf('"%s"', strtr($value, [
            '"'  => '\\"',
        ]));
    }
}
