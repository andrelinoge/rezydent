<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */
?>

<ul id="tiny">
    <?php foreach( $items as $item ): ?>
    <li >
        <a href="<?= isset( $item[ 'url' ] ) ? $item[ 'url' ] : '#'; ?>">
            <?= $item[ 'title' ]; ?>
        </a>
        <?php if( isset( $item[ 'items' ] ) ): ?>
        <?php $activeSubItem = isset( $item[ 'active' ] ) ? $item[ 'active' ] : ''; ?>
        <ul>
            <?php foreach( $item[ 'items' ] as $item ): ?>
            <li>
                <a href="<?= isset( $item[ 'url' ] ) ? $item[ 'url' ] : '#'; ?>">
                    <?= $item[ 'title' ]; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif;?>
    </li>
    <?php endforeach; ?>
</ul>