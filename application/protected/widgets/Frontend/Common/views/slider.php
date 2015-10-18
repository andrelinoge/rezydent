<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */
$baseUrl = $this->getController()->getBehavioralBaseUrl();

$count = count( $propositions );
/** @var $propositions Propositions[] */
?>
<? if( $count > 0 ): ?>
    <div class="slider-wrapper">
        <div class="bannercontainer" style="height: 400px;">
            <div class="banner" style="height: 380px;">
                <ul>
                    <? foreach( $slides as $slide ): ?>
                        <li data-transition="random">
                            <img src="<?= $slide; ?>" alt="" width="1040px" height="380px"/>
                            <? // left top?>
                            <? for( $i = 0; $i < $count; $i++ ): ?>
                            <div class="caption <?= $animations[ rand( 0, 3 ) ]; ?>"
                                 data-x="<?= $coords[ $i ][ 'x' ]; ?>"
                                 data-y="<?= $coords[ $i ][ 'y' ]; ?>"
                                 data-speed="<?= rand( 1000, 1500 ); ?>"
                                 data-start="<?= rand( 800, 900 ); ?>"
                                 data-easing="easeOutSine">
                                <div>
                                    <?
                                        $url = createUrl(
                                            'proposition/show',
                                            array(
                                                'key' => $propositions[ $i ]->getTitleAsUrlParam( TRUE ),
                                                'id' => $propositions[ $i ]->id
                                            )
                                        );
                                    ?>
                                    <a href="<?= $url; ?>" style="text-align: center;">
                                        <img src="<?= $propositions[ $i ]->getSmallThumbnail(); ?>"
                                             alt="<?= $propositions[ $i ]->getTitle(); ?>"
                                            />
                                        <h4 style="color: #fff;"><?= $propositions[ $i ]->getTitle(); ?></h4>
                                    </a>
                                </div>
                            </div>
                            <? endfor; ?>
                        </li>
                    <? endforeach; ?>
                </ul>
                <div class="tp-bannertimer tp-bottom"></div>
            </div>
        </div>
        <div class="slider-shadow"></div>
    </div>
<? endif; ?>

<script>
    $(document).ready(function() {

        if ($.fn.cssOriginal!=undefined)
            $.fn.css = $.fn.cssOriginal;

        $('.full-layout .banner').revolution(
            {
                delay:9000,
                startheight:470,
                startwidth:960,

                navigationType:"bullet",					//bullet, thumb, none, both		(No Thumbs In FullWidth Version !)
                navigationArrows:"verticalcentered",		//nexttobullets, verticalcentered, none
                navigationStyle:"round",				//round,square,navbar

                touchenabled:"on",						// Enable Swipe Function : on/off
                onHoverStop:"on",						// Stop Banner Timet at Hover on Slide on/off

                hideThumbs:200,

                navOffsetHorizontal:0,
                navOffsetVertical:-35,

                stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
                stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

                shadow:0,								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
                fullWidth:"off",							// Turns On or Off the Fullwidth Image Centering in FullWidth Modus


            });

        $('.box-layout .banner').revolution(
            {
                delay:9000,
                startheight:470,
                startwidth:1040,

                navigationType:"bullet",					//bullet, thumb, none, both		(No Thumbs In FullWidth Version !)
                navigationArrows:"verticalcentered",		//nexttobullets, verticalcentered, none
                navigationStyle:"round",				//round,square,navbar

                touchenabled:"on",						// Enable Swipe Function : on/off
                onHoverStop:"on",						// Stop Banner Timet at Hover on Slide on/off

                hideThumbs:200,

                navOffsetHorizontal:0,
                navOffsetVertical:-35,

                stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
                stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

                shadow:0,								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
                fullWidth:"off",							// Turns On or Off the Fullwidth Image Centering in FullWidth Modus


            });



        $('.portfolio-banner').revolution(
            {
                delay:9000,
                startheight:450,
                startwidth:680,

                navigationType:"bullet",					//bullet, thumb, none, both		(No Thumbs In FullWidth Version !)
                navigationArrows:"verticalcentered",		//nexttobullets, verticalcentered, none
                navigationStyle:"round",				//round,square,navbar

                touchenabled:"on",						// Enable Swipe Function : on/off
                onHoverStop:"on",						// Stop Banner Timet at Hover on Slide on/off

                hideThumbs:200,

                navOffsetHorizontal:0,
                navOffsetVertical:-35,

                stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
                stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

                shadow:0,								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
                fullWidth:"off",							// Turns On or Off the Fullwidth Image Centering in FullWidth Modus


            });

        $('.full-portfolio-banner').revolution(
            {
                delay:9000,
                startheight:470,
                startwidth:980,

                navigationType:"bullet",					//bullet, thumb, none, both		(No Thumbs In FullWidth Version !)
                navigationArrows:"verticalcentered",		//nexttobullets, verticalcentered, none
                navigationStyle:"round",				//round,square,navbar

                touchenabled:"on",						// Enable Swipe Function : on/off
                onHoverStop:"on",						// Stop Banner Timet at Hover on Slide on/off

                hideThumbs:200,

                navOffsetHorizontal:0,
                navOffsetVertical:-35,

                stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
                stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

                shadow:0,								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
                fullWidth:"off",							// Turns On or Off the Fullwidth Image Centering in FullWidth Modus


            });




    });

</script>