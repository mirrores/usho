<?php include_once "protected/views/alumni/alumni_ranking.php"; ?>

<?php foreach ($records as $key => $r): ?>
<p><?= $r->id ?>、<?= $r->title ?><br />

    <?php foreach ($r->tags as $t): ?>
    Tags :<span> <a href="<?= Yii::app()->createUrl('tags/view',array('id'=>$t->id)); ?>" ><?= $t->tag ?></a></span>
    <?php endforeach; ?>
</p>
<?php endforeach; ?>