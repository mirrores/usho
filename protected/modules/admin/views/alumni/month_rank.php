<div id="page_head"> 
    <p class="title" style="width: 150px;">校友会月排名更新</p>
</div>
<br>
<div>总共有<?= $amount; ?>个校友会需要更新</div>
<br>
<?php
if (!isset($key)) {
    $key = 0;
}
?>

<form method="post" action="<?= $this->createUrl('/admin/alumni/monthRank') ?>" id="update_form">
    <div>更新月份 <input type="text" name="month" value="<?= isset($month) ? $month : date('Y-m'); ?>"></div>
    <input type="hidden" name="key" value="<?= $key; ?>">
    <input type="submit" value="开始更新">
</form>
<br>

<?php if (isset($alumni)) { ?>
    <div>
        <?= '第' . $key . '个更新<br>'; ?>
        <div style="width: 100px; float: left;">ID</div><?= $alumni['id'] . '<br>'; ?>
        <div style="width: 100px; float: left;">名称</div><?= $alumni['name'] . '<br>'; ?>
        <div style="width: 100px; float: left;">月新闻总数</div><?= $alumni['month_news_count'] . '<br>'; ?>
        <div style="width: 100px; float: left;">新闻总数</div><?= $alumni['news_count'] . '<br>'; ?>
        <div style="width: 100px; float: left;">月活动总数</div><?= $alumni['month_event_count'] . '<br>'; ?>
        <div style="width: 100px; float: left;">活动总数</div><?= $alumni['event_count'] . '<br>'; ?>
        <div style="width: 100px; float: left;">月微博总数</div><?= $alumni['month_weibo_count'] . '<br>'; ?>
        <div style="width: 100px; float: left;">微博总数</div><?= $alumni['weibo_count'] . '<br>'; ?>
        <div style="width: 100px; float: left;">月活跃度</div><?= $alumni['month_rank'] . '<br>'; ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            window.setTimeout(function() {
                $('#update_form').submit();
            }, 500);
        });
    </script>
<?php } ?>
<br><br>
<?php if(isset($finish)){
    echo '<div>更新成功！</div>';
}?>
