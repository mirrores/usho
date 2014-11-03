<script type="text/javascript">
     var UEDITOR_HOME_URL='<?= Yii::app()->baseUrl ?>/static/editor/ueditor1_4_3/';
</script>
<script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/editor/ueditor1_4_3/ueditor.config.js"></script>
<script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/editor/ueditor1_4_3/ueditor.all.min.js"></script>
<script type="text/javascript">
    var $utextarea = $('#<?= $id ?>');
//    if (!$utextarea[0]) {
//        return false;
//    }
    window.ueditor = new baidu.editor.ui.Editor({
        toolbars: [[<?= $options['toolbars'] ?>]],
        enterTag: '<?= $options['enterTag'] ?>',
        initialStyle: <?= $options['initialStyle'] ?>,
        zIndex: <?= $options['zIndex'] ?>,
        autoFloatEnabled:<?= $options['autoFloatEnabled'] ?>,
        elementPathEnabled: <?= $options['elementPathEnabled'] ?>,
        autoHeightEnabled: <?= $options['autoHeightEnabled'] ?>,
        focus: <?= $options['focus'] ?>,
        iframeCssUrl: '<?= Yii::app()->baseUrl ?>/static/editor/ueditor1_2_6_0/themes/default/iframe.css'
    });
    ueditor.render("<?= $id ?>");
</script>


