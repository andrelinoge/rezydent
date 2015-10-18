<?
/** @var $this TouristDatingController */
/** @var $scheduledTrips Trip[] */
/** @var $pastTrips Trip[] */

$baseUrl = $this->getBehavioralBaseUrl();

$onFocus = 'frontendController.removeErrorHighlighting( this )';
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
            <a class="button navy" href="<?= $this->createUrl( 'CreateUpdateTrip' ); ?>">
                Запланувати поїздку
            </a>
            <div class="clear"></div>
            <div class="tabs tab-container">
                <ul class="etabs">
                    <li class="tab">
                        <a href="#scheduled">
                            <span class="icon-calendar-1"></span> Заплановані поїздки
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#past">
                            <span class="icon-ok-circle"></span> Минулі поїздки
                        </a>
                    </li>
                </ul>

                <div class="panel-container">
                    <input type="hidden" value="<?= count( $scheduledTrips ); ?>" id="scheduledCount" />
                    <div id="scheduled">
                        <? if( is_array( $scheduledTrips ) ): ?>
                            <table class="myTrips">
                                <thead>
                                    <td>
                                        Їду в
                                    </td>
                                    <td>
                                        Термін поїздки
                                    </td>
                                    <td>
                                        Створено
                                    </td>
                                    <td>
                                        Переглядів
                                    </td>
                                    <td>
                                        Дії
                                    </td>
                                </thead>

                                <tbody>
                                    <? foreach( $scheduledTrips as $trip ): ?>
                                        <tr id="item-<?= $trip->id; ?>" style="text-align: center">
                                            <td style="text-align: left">
                                                <a href="<?= $this->createUrl( 'myTrip', array( 'id' => $trip->id ) ); ?>">
                                                    <?= $trip->getCountry(); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= $this->createUrl( 'myTrip', array( 'id' => $trip->id ) ); ?>">
                                                    <?= $trip->getStartAt( FALSE ); ?> <span class="icon-right"></span> <?= $trip->getEndAt( FALSE ); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= $this->createUrl( 'myTrip', array( 'id' => $trip->id ) ); ?>">
                                                    <?= $trip->getCreatedAt( FALSE ); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= $this->createUrl( 'myTrip', array( 'id' => $trip->id ) ); ?>">
                                                    <?= $trip->getViews(); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= $this->createUrl( 'CreateUpdateTrip', array( 'id' => $trip->id ) )?>"
                                                   style="padding: 0 10px; margin-right: 10px;"
                                                   class="button navy">
                                                    <span class="icon-edit"></span>
                                                    Редагувати
                                                </a>
                                                <a href="#"
                                                   class="deleteTrip button red"
                                                   style="padding: 0 10px"
                                                   data-id="<?= $trip->id; ?>">
                                                    <span class="icon-erase"></span>
                                                    Видалити
                                                </a>
                                            </td>
                                        </tr>
                                    <? endforeach; ?>
                                </tbody>
                            </table>
                        <? else: ?>
                            <p>
                                Запланованих поїздок ще немає
                            </p>
                        <? endif; ?>
                    </div>

                    <div id="past">
                        <?
                            $this->renderPartial(
                                '_my-past-trips',
                                array(
                                    'trips' => $pastTrips,
                                    'pagination' => $myPastTripsPagination
                                )
                            );
                        ?>
                    </div>
                </div>
            </div>
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
    $(document).ready( function() {
        $('.tabs').easytabs({
            animationSpeed: 300,
            updateHash: false
        });

        $( document ).on(
            'click',
            '#past a.pastTripsPagerButton',
            function( event )
            {
                $( '#past').load( $( event.target).attr( 'href' ) );
                return false;
            }
        );

        $( document ).on(
            'click',
            '#scheduled a.deleteTrip',
            function( event )
            {
                if ( confirm( 'Видалити поїздку?' ) )
                {
                    var id = $( event.target).data( 'id' );
                    var $counter = $( '#scheduledCount' );
                    frontendController.ajaxPost(
                        '<?= $this->createUrl( 'deleteTripHandler' ); ?>',
                        { 'id' : id },
                        function( data )
                        {
                            if ( data.status == true )
                            {

                                if ( $counter.val() > 1 )
                                {
                                    $counter.val( $counter.val() - 1 );
                                    $( '#item-' + id ).remove();
                                }
                                else
                                {
                                    location.reload();
                                }
                            }
                        }
                    );
                }
                return false;
            }
        );

        $( document ).on(
            'click',
            '#past a.deleteTrip',
            function( event )
            {
                if ( confirm( 'Видалити поїздку?' ) )
                {
                    var id = $( event.target).data( 'id' );
                    var $counter = $( '#pastCount' );
                    frontendController.ajaxPost(
                        '<?= $this->createUrl( 'deleteTripHandler' ); ?>',
                        { 'id' : id },
                        function( data )
                        {
                            if ( data.status == true )
                            {

                                if ( $counter.val() > 1 )
                                {
                                    $counter.val( $counter.val() - 1 );
                                    $( '#item-' + id ).remove();
                                }
                                else
                                {
                                    location.reload();
                                }
                            }
                        }
                    );
                }
                return false;
            }
        );
    });
</script>