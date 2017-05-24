<?php

/**
 * Partial template for Mastodon login form
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
/** @var $var variables */
?>
<form method="post" action="<?= h(router()->makePath('post_login')) ?>">
    <fieldset>
        <legend>Input your Mastodon account:</legend>
        <p>ex) <code><var>example</var>@<var>pawoo.net</var></code></p>
        <input type="text" a name="acct" pattern="[_0-9a-z]+@[-0-9a-z.]+">
        <button type="submit">login</button>
    </fieldset>
</form>
