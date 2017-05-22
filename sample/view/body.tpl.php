<?php
/**
 * Template for all contents
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
/** @var $var variables */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= h($var->get('title', ['default' => 'PHP Mastodon Sample App'])) ?></title>
</head>
<body>
<?php isset($main_tpl) && include $main_tpl; ?>
</body>
</html>
