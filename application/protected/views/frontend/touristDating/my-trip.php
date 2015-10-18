<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $model Trip */
/** @var $this TouristDatingController */
?>

<div class="white-wrapper">
    <div class="inner" id="content-container">
        <?
        $this->widget(
            'application.widgets.Templated.BreadCrumbs',
            array(
                'viewFile' => 'frontend',
                'items' => $this->breadcrumbs
            )
        );
        ?>

        <div class="content">
            <table class="tripInfo">
                <tr>
                    <td>
                        Їду в
                    </td>
                    <td>
                        <strong>
                            <?= $model->getCountry(); ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        Термін
                    </td>
                    <td>
                        З <strong><?= $model->getStartAt(); ?></strong> До <strong><?= $model->getEndAt(); ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        Поїздку заплановано
                    </td>
                    <td>
                        <strong><?= $model->getCreatedAt() ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        Для
                    </td>
                    <td>
                        <strong><?= $model->getPurpose(); ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        Їду з
                    </td>
                    <td>
                        <strong><?= $model->getWith(); ?></strong>
                    </td>
                </tr>

                <tr>
                    <td>
                        Шукаю
                    </td>
                    <td>
                        <strong><?= $model->getCompanion(); ?></strong>
                    </td>
                </tr>

                <tr>
                    <td>
                        Кількість дітей
                    </td>
                    <td>
                        <strong><?= $model->getChildren(); ?></strong>
                    </td>
                </tr>

                <tr>
                    <td>
                        Наявність квитків
                    </td>
                    <td>
                        <strong><?= $model->getTicketsValue(); ?></strong>
                    </td>
                </tr>

                <tr>
                    <td>
                        Заброньовано готель
                    </td>
                    <td>
                        <strong><?= $model->getHotelValue(); ?></strong>
                    </td>
                </tr>

                <tr>
                    <td>
                        Переглядів
                    </td>
                    <td>
                        <strong><?= $model->getViews(); ?></strong>
                    </td>
                </tr>

                <tr>
                    <td>
                        Ваш коментар
                    </td>
                    <td>
                        <strong><?= $model->getComment(); ?></strong>
                    </td>
                </tr>
            </table>
            <br/>
            <a href="<?= $this->createUrl( 'CreateUpdateTrip', array( 'id' => $model->id ) ); ?>"
               class="button">
                <span class="icon-edit"></span>
                Редагувати
            </a>
            <a href="<?= $this->createUrl( 'deleteTripHandler', array( 'id' => $model->id ) ); ?>"
               onclick="return deleteTrip( this );"
               class="button red">
                <span class="icon-erase"></span>
                Видалити
            </a>
        </div>

        <div class="sidebar">
            <div class="sidebox">
                <? $this->widget( 'application.widgets.Frontend.Dating.AccountSideBar' ); ?>
            </div>

            <div class="sidebox">
                <? $this->widget( 'application.widgets.Frontend.Common.Tours' ); ?>
            </div>
        </div>

        <div class="clear"></div>

    </div>
</div>

<script>
    function deleteTrip( caller )
    {
        if ( confirm( 'Видалити поїздку?' ) )
        {
            frontendController.ajaxPost(
                $( caller ).attr( 'href' ),
                {},
                function( data )
                {
                    if ( data.status == true )
                    {
                        window.location = '<?= $this->createUrl( 'myTrips' ); ?>';
                    }
                }
            );
        }
        return false;
    }
</script>