<?php
/**
 * Template for index
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
/** @var $var variables */
?>
<h1>Mastodon Sample App</h1>

<ul>
    <?php foreach ($_SESSION['mastodons'] as $acct => $mastodon): ?>
        <li>
            <a href="<?= h(router()->makePath('acct', ['acct' => $acct])) ?>">
                <?= h($acct) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php include __DIR__ . '/_login.tpl.php'; ?>
