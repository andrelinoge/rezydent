<?php
/**
 * @author: Andriy Tolstokorov
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

<ul class="breadcrumb">
    <? foreach( $items as $title => $url ): ?>
        <? $url = is_string( $url ) ? $url : '#'; ?>
        <li>
            <a href="<?= $url ?>"><?= $title ?></a>
            <span class="divider">></span>
        </li>
    <? endforeach ?>
    <li class="active"><?= $lastTitle ?></li>
</ul>