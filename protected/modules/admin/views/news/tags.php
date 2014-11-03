<div id="page_head"> 
    <p class="title" style="width: 150px;">新闻标题分词</p>
</div>

<form method="post" action="<?= $this->createUrl('/admin/news/doAll') ?>" id="update_form">
    <input type="hidden" name="id" value="<?= isset($id) ? $id : NULL; ?>">
    <input type="submit" value="开始更新">
</form>
<br>

<?php
if (isset($finish)) {
    echo '<div>更新成功！</div>';
} else {
    ?>
    <div>
        <div style="width: 100px; float: left;">ID</div><?= $id . '<br>'; ?>
        <div style="width: 100px; float: left;">新闻标题</div><?= $title . '<br>'; ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            window.setTimeout(function() {
                $('#update_form').submit();
            }, 500);
        });
    </script>
<?php } ?>