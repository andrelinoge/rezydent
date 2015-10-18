<?php
/**
 * @author Andre Linoge
 * Date: 9/18/12
 *
 * Use $buttons as buttons array to render pager
 * Use $pagination if need
 * $buttons=>array(
 *  array( label, url, isHidden, isSelected ),
 *  array( label, url, isHidden, isSelected ), ...
 * )
 */
?>

<div class="page-navi">
    <ul>
        <? if( $firstPageButton ): ?>
            <? if ( !$firstPageButton[ 'isHidden' ] ) : ?>
                <li>
                    <a class="outcomingPagerButton" href="<?= $firstPageButton[ 'url' ]; ?>"><?= $firstPageButton[ 'label' ]; ?></a>
                </li>
            <? endif; ?>
        <? endif; ?>

        <? if( $prevPageButton ): ?>
            <? if ( !$prevPageButton[ 'isHidden' ] ) : ?>
                <li>
                    <a class="outcomingPagerButton" href="<?= $prevPageButton[ 'url' ]; ?>"><?= $prevPageButton[ 'label' ]; ?></a>
                </li>
            <? endif; ?>
        <? endif; ?>

        <?php foreach( $buttons as $button ): ?>
            <?php
                $class = 'outcomingPagerButton';
                $onClick = '';
                $buttonClass = 'class="outcomingPagerButton"';
                if ( $button[ 'isHidden' ] ) {
                    $class = 'class="disabled"';
                    $onClick = 'onclick="return false;"';
                    $buttonClass = '';
                }
                if ( $button[ 'isSelected' ] ) {
                    $class = 'class="current"';
                    $buttonClass = '';
                }
            ?>
            <li <?php echo $class; ?>>
                <a <?php echo $onClick; ?> <?php echo $buttonClass; ?>
                    href="<?php echo $button[ 'url' ]; ?>"><?php echo $button[ 'label' ]; ?></a>
            </li>
        <?php endforeach; ?>

        <? if( $nextPageButton ): ?>
            <? if ( !$nextPageButton[ 'isHidden' ] ) : ?>
                <li>
                    <a class="outcomingPagerButton"  href="<?= $nextPageButton[ 'url' ]; ?>"><?= $nextPageButton[ 'label' ]; ?></a>
                </li>
            <? endif; ?>
        <? endif; ?>

        <? if( $lastPageButton ): ?>
            <? if ( !$lastPageButton[ 'isHidden' ] ) : ?>
                <li>
                    <a class="outcomingPagerButton" href="<?= $lastPageButton[ 'url' ]; ?>"><?= $lastPageButton[ 'label' ]; ?></a>
                </li>
            <? endif; ?>
        <? endif; ?>
    </ul>
</div>