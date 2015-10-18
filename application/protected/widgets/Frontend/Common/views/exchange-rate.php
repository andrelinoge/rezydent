<?
$baseUrl = $this->getController()->getBehavioralBaseUrl();
?>
<span style="display:block; margin-top: -3px; clear: none; float: left;">
Курси валют
</span>
&nbsp;
<img alt = "Доллар"
     src = "<?= $baseUrl?>/style/images/dollar.png"
     style="display: inline-block; float: left; margin-left: 5px;">
<span style="display:block; margin-top: -3px; clear: none; float: left; margin-left: 10px;">
<?= $dollar; ?> грн
</span>
&nbsp;
<img alt = "Євро"
     src = "<?= $baseUrl?>/style/images/euro.png"
     style = "display: inline-block; float: left; margin-left: 5px;">
<span style="display:block; margin-top: -3px; clear: none; float: left; margin-left: 10px;">
<?= $euro; ?> грн
</span>
&nbsp;
<img alt = "Російський рубиль"
     src = "<?= $baseUrl?>/style/images/pln.png"
     style="display: inline-block; float: left; margin-left: 5px;">
<span style="display:block; margin-top: -3px; clear: none; float: left; margin-left: 10px;">
<?= $pln; ?> грн
</span>
