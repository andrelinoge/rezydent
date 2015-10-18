<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */

$title = $pageModel->getTitle();
$text = $pageModel->getText();

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

        <? if( !empty( $title ) ): ?>
            <h1 class="line"><?= $title; ?></h1>
        <? endif; ?>
        <? if( !empty( $text ) ): ?>
            <div class="content">
                <?= $text; ?>
            </div>
            <div class="clear"></div>
        <? endif; ?>


        <div class="center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform35" align="middle" height="240" width="188"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform35.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=6FD3FF&amp;txtcolor=00A686&amp;country=Ukraine&amp;city=Kyiv, Dnipropetrovsk, Donetsk, Lviv, Odesa, Kharkiv"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=6FD3FF&amp;txtcolor=00A686&amp;country=Ukraine&amp;city=Kyiv, Dnipropetrovsk, Donetsk, Lviv, Odesa, Kharkiv" src="http://www.meteoprog.ua//pictures/informers/flash/inform35.swf" quality="high" bgcolor="#FFFFFF" name="inform35" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="240" width="188"></object>
        </div>

        <div class="clear"></div>
        <br/><br/>
        <h4 class="center">Погода на популярных курортах: </h4>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Antalya, Alanya, Bodrum, Davras, Dalaman, Marmaris, Palandoken, Sarikamis, Sivas, Istanbul, Uludag"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Antalya, Alanya, Bodrum, Davras, Dalaman, Marmaris, Palandoken, Sarikamis, Sivas, Istanbul, Uludag" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Hurghada, SharmelSzeikh, Aleksandria, Dahab, Cairo, Luksor, MakadiBey, MarsaAlam, Safaga, SomaBey, Taba, ElGuna"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Aleksandria, Dahab, Cairo, Luksor, MakadiBey, MarsaAlam, Safaga, SomaBey, Taba, Hurghada, SharmelSzeikh, ElGuna" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Dubaj, AbuDhabi, Ajman, RasalChajma, UmmalQuwain, Fujairah, Shardzha"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=AbuDhabi, Dubaj, Ajman, RasalChajma, UmmalQuwain, Fujairah, Shardzha" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Bangkok, Pathiu, Phuket, Chiangmaj"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Bangkok, Pathiu, Phuket, Chiangmaj" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center last">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Monastir, oDzherba, Suss, Tunis, Hammamet"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Tunis, Monastir, Suss, Hammamet, oDzherba" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="clear"></div>
        <br/><br/>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Larnaka, Limassol, Nicosia, Paphos"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Larnaka, Limassol, Nicosia, Paphos" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Albena, GoldenSands, Pamporovo, Plovdiv, Sozopol, SunnyBeach"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Albena, GoldenSands, Pamporovo, Plovdiv, Sozopol, SunnyBeach" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Istria, Porech, Pula, Umag, Budva, HercegNoviFR, Ljubljana, Portoroz"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Istria, Porech, Pula, Umag, Budva, HercegNoviFR" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Crete, Athens, Iraklion, Chania, Paris, Nice"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Crete, Iraklion, Chania, Athens, Paris, Nice" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center last">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=BarcelonaVen, Madrid, Ibiza, ValenciaVen, PalmadeMallorca, Rome, Rimini, Capri"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=BarcelonaVen, Madrid, Ibiza, ValenciaVen, PalmadeMallorca, Rome, Rimini, Capri" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="clear"></div>
        <br/><br/>

        <div class="one-fifth">&nbsp;</div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=TelAviv, Jerusalem, Natanja, Elat, Amman, Akaba, Madaba"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=TelAviv, Jerusalem, Natanja, Elat, Amman, Akaba, Madaba" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Bali, Male, Delhi, Goa, Colombo, KualaLumpur, KotaKinabalu, Johannesburg, CapeTown, Manila, Tokyo, Melbourne, Sydney"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Bali, Male, Delhi, Goa, Colombo, KualaLumpur, KotaKinabalu, Johannesburg, CapeTown, Manila, Tokyo, Melbourne, Sydney" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="one-fifth center">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="inform6" align="middle" height="104" width="134"><param name="allowScriptAccess" value="sameDomain"><param name="allowFullScreen" value="false"><param name="movie" value="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf"><param name="flashVars" value="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Havana, Varadero, PuntaCana, Bridgetown, KingstonJam, MexicoCity, NewYork, Miami, Lima, Brasilia, RiodeJaneiro"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><embed flashvars="url=http://www.meteoprog.ua/ru/informer/&amp;color=38CAFF&amp;txtcolor=A91A00&amp;country=Ukraine&amp;city=Havana, Varadero, PuntaCana, Bridgetown, KingstonJam, MexicoCity, NewYork, Miami, Lima, Brasilia, RiodeJaneiro" src="http://www.meteoprog.ua//pictures/informers/flash/inform6.swf" quality="high" bgcolor="#FFFFFF" name="inform6" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" align="middle" height="104" width="134"></object>
        </div>

        <div class="clear"></div>
        <br/><br/>
        <!--
        <a class="button aqua" href="<?= $this->createUrl( 'index' ); ?>">Погода на карті світу</a>
        &nbsp;&nbsp;
        <a class="button aqua" href="<?= $this->createUrl( 'sea' ); ?>">Температура морів</a>
        -->
        <div class="clear"></div>
    </div>
</div>