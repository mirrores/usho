<?php

//排行查询
class Ranking extends CActiveRecord {

    /**
     * 查询校友会排行
     * @static
     * @access public
     * @param expire 缓存时间 
     * @return mixed array()
     * @example
     */
    public static function getAlumniRanking($expire=3600) {
        if (Yii::app()->cache->get('all_rank')) {
            $top_alumnis = Yii::app()->cache->get('all_rank');
        } else {
            $top_alumnis = Yii::app()->db->createCommand('select * from alumni order by month_rank DESC limit 0,13')->queryAll();
            Yii::app()->cache->add('all_rank', $top_alumnis, $expire);
        }
        return $top_alumnis;
    }

}
