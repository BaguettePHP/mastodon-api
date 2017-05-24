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
<html itemscope itemtype="http://n.whatwg.org/work" itemref="licenses">
<head>
    <title><?= h($var->get('title', ['default' => 'PHP Mastodon Sample App'])) ?></title>
</head>
<body itemprop="work">
<div>
    <?php foreach (last_flash() as $key => $message): ?>
        <p><?= h($message) ?></p>
    <?php endforeach; ?>
</div>
<?php isset($main_tpl) && include $main_tpl; ?>
<hr>
<footer>
    <address>
        Copyright (c) 2017 <a href="https://github.com/BaguettePHP">Baguette HQ</a> / USAMI Kenta (<a href="https://github.com/zonuexe">@zonuexe</a>)
        <br>
        <a href="https://github.com/BaguettePHP/mastodon-api/">Baguette PHP Mastodon API Client / SDK</a>
        <span id="licenses">licensed under <a itemprop="license" href="<?= h(router()->makePath('license')) ?>">GPLv3 or later</a></span>
    </address>
</footer>
</body>
</html>
