<!--通过html的iframeset标签集合头部、左侧、右侧-->
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></meta>
        <title>内容管理系统</title>
    </head>
    <body style="margin: 0;padding: 0">
        <table style="width:100%">
            <tr>
                <td colspan="2" style="height:60px" valign="top">
                    <iframe src="<?=$this->createUrl('/admin/index/head')?>" name="head" scrolling="no" frameborder="0" id="frmtop" style="height: 60px; width: 100%;"></iframe>
                </td>
            </tr>
            <tr>
                <td valign="top" style="height:600px;width: 185px" ><iframe src="<?=$this->createUrl('/admin/index/left')?>" noresize frameborder="0" scrolling="no" id="left" name="left" style="height: 100%; width: 185px;" ></iframe></td>
                <td valign="top" style="height:650px;width:100%" ><iframe src="<?=$this->createUrl('/admin/index/right')?>" scrolling="yes" frameborder="0"  name="right" id="right"  style="height: 100%; width: 100%;" ></iframe></td>
            </tr>
        </table>
    </body>
</html>