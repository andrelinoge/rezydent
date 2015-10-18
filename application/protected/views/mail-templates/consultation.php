<?php
/**
 * @author Andriy Tolstokorov
 */
?>

Замовлення консультації для
<? if ( $email ): ?>
    <a href="mailto:<?= $email; ?>?subject=Відповідь від турагенства РЕЗИДЕНТ"><?= $name; ?></a>
<? else: ?>
    <?= $name; ?>
<? endif; ?>
<br/>
Текст повідомлення:<br/>
<?= $message; ?>
<br/>
Телефон:<br/>
<?= $phone; ?>
<br/>
Скайп:<br/>
<?= $skype; ?>
