<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/pager.css" type="text/css" rel="stylesheet" />
<!--body-->
<div class="m m_b14">
    <div class="y_pm f_left">
        <?php echo Controller::actionGetRanking(); ?>
        <span class="link_ad1"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ad_1.jpg" /></span>
    </div>

    <!---->
    <div class="monthly_list w_780">
        <dl class="k_dl3">
            <dt>
            <h1><?= $name;?></h1><em></em></dt>
            <dd>
                <div style="width: 690px; margin-left: 35px">
                    <?= $template['content'];?>
                </div>
                
            </dd>
        </dl>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>