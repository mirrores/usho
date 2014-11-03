<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo CHtml::encode($this->pageTitle ? $this->pageTitle : '管理后台'); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS_URL ?>base.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS_URL ?>form.css"/>
        <script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jQuery-1.9.1.js"></script>
    </head>
    <body background='<?php echo ADMIN_IMG_URL ?>allbg.gif' style="padding: 10px">
        <?php echo $content; ?>
    </body>
</html>
