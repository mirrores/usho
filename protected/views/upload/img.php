<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>上传附件</title>
        <style type="text/css">
            body{ margin:0px; font-size:12px; font-family:Verdana;}
        </style>
    </head>
    <body>
        <?php
        //前台隐藏路径文本域ID
        $params['hidden_fieid'] = Yii::app()->request->getParam('hidden_fieid', 'img_path');
        //上传文本序号，区别多个上传框
        $params['no'] = Yii::app()->request->getParam('no');
        //上传提示
        $params['msg'] = Yii::app()->request->getParam('msg','（文件不大于5M)');
        //图片规格
        $params['resize'] = Yii::app()->request->getParam('resize');
        //要返回的规格名称
        $params['return_size_name'] = Yii::app()->request->getParam('return_size_name');
        //指定绝对路径前缀，默认为项目名称/
        $params['prefix_path'] = Yii::app()->request->getParam('prefix_path');
        //提交和返回地址
        $url = $this->createUrl('img', $params);
        ?>
        
        <script language="javascript">
            //提交表单时
            function submitform() {
                parent.document.getElementById("uploading<?= $params['no'] ?>").style.display = "block";
                parent.document.getElementById("upfileframe<?= $params['no'] ?>").style.display = "none";
                document.getElementById("uploadform<?= $params['no'] ?>").submit();
            }
<?php if (isset($error) AND $error): ?>
                //错误提示
                parent.document.getElementById("uploading<?= $params['no'] ?>").style.display = "none";
                parent.document.getElementById("upfileframe<?= $params['no'] ?>").style.display = "block";
                alert('<?= $error ?>');
<?php endif ?>
        </script>

        <?php if (isset($return_file_path) AND $return_file_path): ?>
            <div style="font-size:12px; color:#393; height:25px; line-height:25px">文件上传成功！<a href="<?= $url ?>" style="font-size:12px;text-decoration:none; color:#393">点击重新上传</a></div>
            <script language="javascript">
                //向父级页面返回数据
                //隐藏loging
                parent.document.getElementById("uploading<?= $params['no'] ?>").style.display = "none";
                //重新显示上传文本域
                parent.document.getElementById("upfileframe<?= $params['no'] ?>").style.display = "block";
                //为表单赋值
                parent.document.getElementById("<?= $params['hidden_fieid'] ?>").value = "<?= $return_file_path ?>";
                setTimeout(function() {
                    window.location.href = "<?= $url ?>";
                }, 9000);
            </script>
        <?php else: ?>
            <form id="uploadform" name="uploadform" enctype="multipart/form-data" method="post" action="<?= $url ?>" style="margin:0px" onsubmit="submitform()" >
                <input type="file" name="file"   />
                <input type="submit" name="button" id="button" value="上传" />
                <span style="color:#999">
                    <?php if ($params['msg']): ?><?=$params['msg'] ?><?php else: ?>（文件不大于5M)<?php endif; ?></span>
            </form>
        <?php endif; ?>
    </body>
</html>