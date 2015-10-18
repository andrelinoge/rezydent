<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $pagination CPagination */
?>


<div class="dataTables_paginate paging_full_numbers" >
    <? //  RENDER FIRST PAGE BUTTON ?>
    <? if( $firstPageButton ): ?>
    <?
    $class = '';
    $onClick = 'return onLoadPage(this, \'' . $widgetWrapperId . '\' );';
    if ( $firstPageButton[ 'isHidden' ] ) {
        $class = 'paginate_button_disabled';
        $onClick = 'return false;';
    }
    ?>
    <a  onclick = "<?= $onClick; ?>"
        class="first paginate_button <?= $class; ?>"
        href="<?= $firstPageButton[ 'url' ]; ?>"><?= $firstPageButton[ 'label' ]; ?></a>
    <? endif; ?>

    <? //  RENDER PREV PAGE BUTTON ?>
    <? if( $prevPageButton ): ?>
    <?
    $class = '';
    $onClick = 'return onLoadPage(this, \'' . $widgetWrapperId . '\' );';
    if ( $prevPageButton[ 'isHidden' ] ) {
        $class = 'paginate_button_disabled';
        $onClick = 'return false;';
    }
    ?>
    <a  onclick = "<?= $onClick; ?>"
        class="first paginate_button <?= $class; ?>"
        href="<?= $prevPageButton[ 'url' ]; ?>"><?= $prevPageButton[ 'label' ]; ?></a>
    <? endif; ?>

    <? //  RENDER PAGE BUTTONS ?>
    <? foreach( $buttons as $button ): ?>
    <?
    $class = 'paginate_button';
    $onClick = 'return onLoadPage(this, \'' . $widgetWrapperId . '\' );';
    if ( $button[ 'isHidden' ] ) {
        $class = 'paginate_button paginate_button_disabled';
        $onClick = 'return false;';
    }
    if ( $button[ 'isSelected' ] ) {
        $class = 'paginate_active';
        $onClick = 'return false;';
    }
    ?>
    <span>
            <a onclick="<?= $onClick; ?>"
               class="<?= $class; ?>"
               href="<?= $button[ 'url' ]; ?>"><?= $button[ 'label' ]; ?></a>
        </span>
    <? endforeach; ?>

    <? //  RENDER NEXT PAGE BUTTON ?>
    <? if( $nextPageButton ): ?>
    <?
    $class = '';
    $onClick = 'return onLoadPage(this, \'' . $widgetWrapperId . '\' );';
    if ( $nextPageButton[ 'isHidden' ] ) {
        $class = 'paginate_button_disabled';
        $onClick = 'return false;';
    }
    ?>
    <a  onclick = "<?= $onClick; ?>"
        class="first paginate_button <?= $class; ?>"
        href="<?= $nextPageButton[ 'url' ]; ?>"><?= $nextPageButton[ 'label' ]; ?></a>
    <? endif; ?>

    <? //  RENDER LAST PAGE BUTTON ?>
    <? if( $lastPageButton ): ?>
    <?
    $class = '';
    $onClick = 'return onLoadPage(this, \'' . $widgetWrapperId . '\');';
    if ( $lastPageButton[ 'isHidden' ] ) {
        $class = 'paginate_button_disabled';
        $onClick = 'return false;';
    }
    ?>
    <a  onclick = "<?= $onClick; ?>"
        class="first paginate_button <?= $class; ?>"
        href="<?= $lastPageButton[ 'url' ]; ?>"><?= $lastPageButton[ 'label' ]; ?></a>
    <? endif; ?>
</div>

<script type="text/javascript">
    function onLoadPage( link, contentWrapperId ) {
        jQuery( '#' +  contentWrapperId ).load(
                jQuery( link ).attr( 'href' ),
                function() {
                    jQuery( 'form' ).find( 'input:checkbox' ).uniform();
                }
        );
        return false;
    }
</script>