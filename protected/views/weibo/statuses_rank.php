<dl class="k_dl1 m_b14">
    <dt><h1>微博数排行</h1><em></em></dt>
    <dd>
        <ul class="pmlist_ul">
            <?php
            $i = 1;
            foreach ($data as $key => $value) {
                ?>
                <li>
                    <?php
                    if ($key) {
                        if ($data[$key]['statuses_count'] != $data[$key - 1]['statuses_count'])
                            $i = $key + 1;
                    }
                    if ($i == 1) {
                        echo '<em class="a">' . $i . '</em>';
                    } elseif ($i == 2 || $i == 3) {
                        echo '<em class="b">' . $i . '</em>';
                    } elseif ($i > 3 && $i < 11) {
                        echo '<em class="c">' . $i . '</em>';
                    } else {
                        echo '<em class="d">' . $i . '</em>';
                    }
                    ?>
                    <a href="http://www.weibo.com/u/<?=$value['user_id'] ?>" target="_blank"><?= $value['screen_name']; ?></a>
                    <p style=" float: right"><a style="color: #3993E0;cursor:pointer;"><?= $value['statuses_count']; ?></a></p>
                    <div style="clear:both;"></div>
                </li>
            <?php } ?>
        </ul>
    </dd>
</dl>
