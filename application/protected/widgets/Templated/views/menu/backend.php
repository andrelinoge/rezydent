<?php
/**
 * User: andrelinoge
 * Date: 12/4/12
 * BackEnd Menu Template
 */

?>
<ul class="navigation">
    <?php foreach( $items as $item ): ?>
    <?php $hasSubItems = isset( $item[ 'items' ] ); ?>
    <?php
        $class = $hasSubItems ? 'openable' : '';
        if( $active == $item[ 'activityMarker' ] ) {
            $class .= ' active';
        }
    ?>

    <li class="<?= $class; ?>">
        <a href="<?= isset( $item[ 'url' ] ) ? $item[ 'url' ] : '#'; ?>" >
            <span class="text"><?= $item[ 'title' ]; ?></span>
        </a>
        <?php if( $hasSubItems ): ?>
            <?php $activeSubItem = isset( $item[ 'active' ] ) ? $item[ 'active' ] : ''; ?>
            <ul>
                <?php foreach( $item[ 'items' ] as $subitem ): ?>
                <li>
                    <a href="<?= isset( $subitem[ 'url' ] ) ? $subitem[ 'url' ] : '#'; ?>">
                        <span class="text"><?= $subitem[ 'title' ]; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif;?>
    </li>
    <?php endforeach; ?>
</ul>