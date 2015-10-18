<?php
/**
 * User: andrelinoge
 * Date: 12/4/12
*/

//          This is simple template for menu
?>

<ul class="navigation">
    <?php foreach( $items as $item ): ?>
    <li class="<?=isset( $item['class']) ? $item['class']: ''; ?>">
        <a href="<?= isset( $item[ 'url' ] ) ? $item[ 'url' ] : '#'; ?>"
           class="first <?php if( $active == $item[ 'activityMarker' ] ): ?>current<?php endif;?>">
            <?= $item[ 'title' ]; ?>
        </a>
        <?php if( isset( $item[ 'items' ] ) ): ?>
        <?php $activeSubItem = isset( $item[ 'active' ] ) ? $item[ 'active' ] : ''; ?>
        <ul>
            <?php foreach( $item[ 'items' ] as $item ): ?>
            <li>
                <a href="<?= isset( $item[ 'url' ] ) ? $item[ 'url' ] : '#'; ?>"
                   class="<?php if( $activeSubItem == $item[ 'activityMarker' ] ): ?>current<?php endif;?>">
                    <?= $item[ 'title' ]; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif;?>
    </li>
    <?php endforeach; ?>
</ul>