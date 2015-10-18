<?
/** @var $this EmbassiesController */
/** @var $pageModel StaticPages */
/** @var $countriesWithVisa Embassies[]  */
/** @var $countriesWithoutVisa Embassies[]  */

$title = $pageModel->getTitle();
$text = $pageModel->getText();
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

        <? if( !empty( $title ) ): ?>
            <h1 class="line"><?= $title; ?></h1>
        <? endif; ?>

        <? if( !empty( $text ) ): ?>
            <div class="">
                <?= $text; ?>
            </div>
        <? endif; ?>

        <div class="clear"></div>
        <div class="tabs side-tab-container">
            <ul class="etabs">
                <li class="tab">
                    <a href="#tab-1">
                        <span>1.</span> Візові країни
                    </a>
                </li>
                <li class="tab">
                    <a href="#tab-2">
                        <span>2.</span> Безвізові країни
                    </a>
                </li>
            </ul>
            <div class="panel-container">
                <div id="tab-1" class="tab-item">
                    <? foreach( $countriesWithVisa as $model ): ?>
                        <?
                            $url = $this->createUrl(
                                'show',
                                array(
                                    'key' => $model->getTitleAsUrlParam( TRUE ),
                                    'id' => $model->id
                                )
                            );
                        ?>
                        <h4>
                            <a href="<?= $url; ?>">
                                <?= $model->getCountry();?>
                            </a>
                        </h4>
                        <p>
                            <a href="<?= $url; ?>">
                                <?= $model->getTitle(); ?>
                            </a>
                        </p>
                    <? endforeach; ?>
                </div>
                <div id="tab-2" class="tab-item">
                    <? foreach( $countriesWithoutVisa as $model ): ?>
                        <?
                            $url = $this->createUrl(
                                'show',
                                array(
                                    'key' => $model->getTitleAsUrlParam( TRUE ),
                                    'id' => $model->id
                                )
                            );
                        ?>
                        <h4>
                            <a href="<?= $url; ?>">
                                <?= $model->getCountry();?>
                            </a>
                        </h4>
                        <p>
                            <a href="<?= $url; ?>">
                                <?= $model->getTitle(); ?>
                            </a>
                        </p>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(
        function()
        {
            $('.tabs').easytabs(
                {
                    animationSpeed: 300,
                    updateHash: false
                }
            );

            var $tabContainer = $('.side-tab-container'),
                $tabs = $tabContainer.data('easytabs').tabs,
                $tabPanels = $(".tab-item");
            totalSize = $tabPanels.length;

            $tabPanels.each(
                function(i)
                {
                    if (i != 0)
                    {
                        prev = i - 1;
                        $(this).prepend("<a href='#' class='prev-tab btn success' rel='" + prev + "'><i class='icon-left-open'></i></a>");
                    }
                    else
                    {
                        $(this).prepend("<span class='prev-tab btn'><i class='icon-left-open'></i></span>");
                    }

                    if (i+1 != totalSize)
                    {
                        next = i + 1;
                        $(this).prepend("<a href='#' class='next-tab btn success' rel='" + next + "'><i class='icon-right-open'></i></a>");
                    }
                    else
                    {
                        $(this).prepend("<span class='next-tab btn'><i class='icon-right-open'></i></span>");
                    }
                }
            );

        $('.next-tab, .prev-tab').click(
            function()
            {
                var i = parseInt($(this).attr('rel'));
                var tabSelector = $tabs.children('a:eq(' + i + ')').attr('href');
                $tabContainer.easytabs('select', tabSelector);
                return false;
            }
        );
    });
</script>