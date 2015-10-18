<?php
/**
 * @author Andriy Tolstokorov
 */

// store last item separately
$lastTitle = end( array_keys( $items ) );
$lastValue = end( array_values( $items ) );

// if last item is not key => value pair, use value for $lastTitle
if ( is_numeric( $lastTitle ) )
{
    if ( strpos( $items[ $lastTitle], 'backend.php' ) === FALSE )
    {
        $lastTitle = $lastValue;
    }
}

// remove last item
array_pop( $items );
?>

<div class="switcher">
    <? foreach( $items as $title => $url ): ?>
        <? $url = is_string( $url ) ? $url : '#'; ?>
            <button class="filter" onclick="window.location = '<?= $url ?>'">
                <?= $title ?>
            </button>
    <? endforeach ?>
    <button class="filter active">
        <?= $lastTitle ?>
    </button>
</div>