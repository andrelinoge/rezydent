<?
/** @var $this TouristDatingController */

$baseUrl = $this->getBehavioralBaseUrl();

$onFocus = 'frontendController.removeErrorHighlighting( this )';
?>

<div class="white-wrapper">
    <div class="inner">
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
            <div class="tabs tab-container">
                <ul class="etabs">
                    <li class="tab">
                        <a href="#inbox">
                            <span class="icon-down-circle2"></span> Одержані повідомлення<? if ($countOfNewMessages > 0 ):?> (<?= $countOfNewMessages;?> не прочитаних)<? endif;?>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#outbox">
                            <span class="icon-up-circle2"></span> Надіслані повідомлення
                        </a>
                    </li>
                </ul>

                <div class="panel-container">

                    <div id="inbox">
                        <div class="comments">
                            <h3><?= $incomingCount; ?> Повідомлень</h3>
                            <ol class="commentlist" id="incoming-block">
                                <?
                                $this->renderPartial(
                                    '_incoming',
                                    array(
                                        'messages' => $incoming,
                                        'pagination' => $incomingPagination,
                                    )
                                );
                                ?>
                            </ol>
                        </div>
                    </div>

                    <div id="outbox">
                        <div class="comments">
                            <h3><?= $outcomingCount; ?> Повідомлень</h3>
                            <ol class="commentlist" id="outcoming-block">
                                <?
                                    $this->renderPartial(
                                        '_outcoming',
                                        array(
                                            'messages' => $outcoming,
                                            'pagination' => $outcomingPagination
                                        )
                                    );
                                ?>
                            </ol>
                        </div>
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

        // OnClick event handler for pagination buttons
        $( document ).on(
            'click',
            '#incoming-block a.incomingPagerButton',
            function( event )
            {
                $( '#incoming-block').load( $( event.target).attr( 'href' ) );
                return false;
            }
        );

        $( document ).on(
            'click',
            '#outcoming-block a.outcomingPagerButton',
            function( event )
            {
                $( '#outcoming-block').load( $( event.target).attr( 'href' ) );
                return false;
            }
        );

        $( document ).on(
            'click',
            '#incoming-block a.deleteIncomingMessage',
            function( event )
            {
                if ( confirm( 'Видалити повідомлення?' ) )
                {
                    var id = $( event.target).data( 'id' );
                    var $counter = $( '#incomingCount' );
                    frontendController.ajaxPost(
                        '<?= $this->createUrl( 'deleteMessageHandler' ); ?>',
                        { 'id' : id },
                        function( data )
                        {
                            if ( data.status == true )
                            {

                                if ( $counter.val() > 1 )
                                {
                                    $counter.val( $counter.val() - 1 );
                                    $( '#message-' + id ).remove();
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
            '#outcoming-block a.deleteOutcomingMessage',
            function( event )
            {
                if ( confirm( 'Видалити повідомлення?' ) )
                {
                    var id = $( event.target).data( 'id' );
                    var $counter = $( '#outcomingCount' );
                    frontendController.ajaxPost(
                        '<?= $this->createUrl( 'deleteMessageHandler' ); ?>',
                        { 'id' : id },
                        function( data )
                        {
                            if ( data.status == true )
                            {

                                if ( $counter.val() > 1 )
                                {
                                    $counter.val( $counter.val() - 1 );
                                    $( '#message-' + id).remove();
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