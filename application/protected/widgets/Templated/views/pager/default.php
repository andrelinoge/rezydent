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

<div class="pagination">
    <ul>
        <?php foreach( $buttons as $button ): ?>
            <?php
                $class = '';
                $onClick = '';
                if ( $button[ 'isHidden' ] ) {
                    $class = 'class="disabled"';
                    $onClick = 'onclick="return false;"';
                }
                if ( $button[ 'isSelected' ] ) {
                    $class = 'class="active"';
                }
            ?>
            <li <?php echo $class; ?>>
                <a <?php echo $onClick; ?>
                    href="<?php echo $button[ 'url' ]; ?>"><?php echo $button[ 'label' ]; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>