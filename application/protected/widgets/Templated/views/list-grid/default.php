<?php
/**
 * @author Andre Linoge
 * Date: 10/4/12
 * NOTE: Don`t edit this File!!! This raw template just for example
 */

Yii::import('application.components.widgets.TemplatePager.TemplatePager');
/** @var $model ActiveRecord */
?>

<div id = "tableHolder">
    <?php if ( $isData ): ?>
    <table>
        <thead>
            <tr>
                <?php if ( $enableSort ): ?>
                    <?php foreach( $headers as $field ): ?>
                        <th>
                            <?php if( in_array( $field, $sortableFields ) ): ?>
                                <a href="<?= $this->getUrlForSort( $field ); ?>">
                                    <?= $model->getAttributeLabel( $field ); ?>
                                </a>

                                <?php if( $this->isAscSort( $field ) ): ?>
                                <span>arrow up</span>
                                <?php elseif( $this->isDescSort( $field ) ): ?>
                                    <span>arrow down</span>
                                <?php endif; ?>

                            <?php else: ?>
                                <?= $model->getAttributeLabel( $field ); ?>
                            <?php endif; ?>
                        </th>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach( $headers as $field ): ?>
                        <th><?= $model->getAttributeLabel( $field ); ?></th>
                    <?php endforeach; ?>
                <?php endif; ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $models as $record ): ?>
                <?php $cells = $record->$rowCellsGetterMethod(); ?>
                <tr id="record_<?= $record->$primary; ?>">
                    <?php foreach( $cells as $cell ): ?>
                        <td><?= $cell; ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href = "<?= $this->getEditLink( $record->$primary ); ?>">
                            edit
                        </a>
                        <?php
                            $onClick = 'return confirm(\'' . $deleteConfirm . '\');';
                            if ( $ajaxDelete ) {
                                $onClick = 'return ajaxDelete(this)';
                            }
                        ?>
                        <a href = "<?= $this->getDeleteLink( $record->$primary ); ?>"
                           data-record_id = "<?= $record->$primary; ?>"
                           onclick = "<?= $onClick; ?>">
                            delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        Found nothing!
    <?php endif; ?>

    <?php
        $this->widget(
            'TemplatePager',
            array(
                'pagination'    => $pagination,
            )
        );
    ?>
</div>

<script type="text/javascript">
    function ajaxDelete( caller ) {
        if ( confirm( "<?= $deleteConfirm; ?>" ) ) {
            var $caller = jQuery( caller );
            jQuery.ajax({
                url: $caller.attr( 'href'),
                cache: false,
                type: "GET",
                data: { ajax: "true" }
            }).done(function ( data ) {
                jQuery( '#record_' + $caller.data( 'record_id' ) )
            });
            return false;
        } else {
            return false;
        }
    }
</script>