<div id="page_head"> 
    <p class="title" style="width: 150px;">校友会百度指数更新</p>
</div>
<br>
<div>总共有<?= $max_id; ?>个校友会需要更新</div>
<br><br>
<?php if ($start == 1) { ?>
    <div>
        <?= '第' . $id . '个更新<br>'; ?>
        <?= $alumni['id'] . '<br>'; ?>
        <?= $alumni['name'] . '<br>'; ?>
        <?= $alumni['website'] . '<br>'; ?>
        <?= $alumni['baidu_index'] . '<br>'; ?>
        <?= $alumni['last_collection_date'] . '<br>'; ?>
        <?php $id+=1; ?>
    </div>
    <br>
    <div>
        <input type="submit" value="停止更新" onclick="stop();">
    </div>
    <script type="text/javascript">
        function stop() {
            location.href = "<?= Yii::app()->createUrl('admin/alumni/baiduindex', array('start' => 0)); ?>";
        }
        $(document).ready(function() {
            function jump(count) {
                window.setTimeout(function() {
                    count--;
                    if (count > 0) {
                        jump(count);
                    } else {
                        location.href = "<?= Yii::app()->createUrl('admin/alumni/baiduindex', array('id' => $id, 'max_id' => $max_id, 'start' => 1)); ?>";
                    }
                }, 1000);
            }
            jump(3);
        });
    </script>
<?php } else { ?>
    <?php  if($finish){?>
    <div>
        更新成功！&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="重新更新" onclick="jump();">
    </div>
    <?php }else{?>
    <div>
        <input type="submit" value="开始更新" onclick="jump();">
    </div>
    <script type="text/javascript">
        function jump() {
            location.href = "<?= Yii::app()->createUrl('admin/alumni/baiduindex', array('max_id' => $max_id, 'start' => 1)); ?>";
        }
    </script>
    <?php }
}?>