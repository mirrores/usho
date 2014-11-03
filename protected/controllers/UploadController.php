<?php

//图片上传类
class UploadController extends Controller {

    public $layout = false;
    //图片规格及大小限制
    public $config = array(
        'fileType' => array(".gif", ".png", ".jpg", ".jpeg", ".bmp"), //文件允许格式
        'fileSize' => 5000, //文件大小限制，单位KB
        'size' => array(
            'original' => array('width' => 1000, 'height' => 1000),
            'bmiddle' => array('width' => 640, 'height' => 640),
            'thumbnail' => array('width' => 200, 'height' => 200),
            'mini' => array('width' => 100, 'height' => 100))
    );

    //获取图片存放物理路径，没有目录自动创建
    public function getDirectoryPath() {
        $base_dir = str_replace('protected', '', Yii::app()->basePath) . 'static/uploads/pic/';
        if (!is_dir($base_dir . date('Ym') . '/' . date('d'))) {
            if (!is_dir($base_dir . date('Ym'))) {
                mkdir($base_dir . date('Ym'), 0777);
            }
            mkdir($base_dir . date('Ym') . '/' . date('d'), 0777);
        }
        return $save_dir = $base_dir . date('Ym') . '/' . date('d') . '/';
    }

    /**
     * 返回图片存放路径
     * @access public
     * @param string $prefix_path 参数名称
     * @return string 返回存放地址
     * @example 
     */
    public function getFilePath($prefix_path = null) {
        $prefix_path = $prefix_path ? $prefix_path : Yii::app()->baseUrl . '/';
        return $prefix_path . 'static/uploads/pic/' . date('Ym') . '/' . date('d') . '/';
    }

    //处理表单来的图片内容
    public function actionImg() {

        $view = array();
        //自定义尺寸
        $resize = Yii::app()->request->getParam('resize');
        //返回相对或绝对或指定路径
        $prefix_path = Yii::app()->request->getParam('prefix_path', Yii::app()->baseUrl);
        //上传后返回的规格，默认thumbnail尺寸
        $return_size_name = Yii::app()->request->getParam('return_size_name');

        //接收表单数据
        if ($_POST) {
            //文件名
            $filename = date('YmdHis') . rand(10, 1000);
            //获取附件
            $attach = CUploadedFile::getInstanceByName('file');
            //文件扩展名
            $ext = $attach->extensionName;
            //上传路径及文件名
            $directory_path = $this->getDirectoryPath();
            $upload_path = $directory_path . $filename . '.' . $ext;
            //返回前台的路径
            //原图不带后缀
            if ($return_size_name != 'original') {
                $return_file_path = $this->getFilePath($prefix_path) . $filename . '_' . $return_size_name . '.' . $ext;
            } else {
                $return_file_path = $this->getFilePath($prefix_path) . $filename . '.' . $ext;
            }
            //格式文件验证
            if (!in_array('.' . strtolower($ext), $this->config['fileType'])) {
                $view['error'] = "不支持的图片类型！";
            } elseif ($attach->size > 5 * 1024 * 1024) {
                $view['error'] = "文件大小超过5M";
            } else {
                if ($attach->saveAs($upload_path)) {
                    //生成各种规格缩略图
                    $this->imgcut($directory_path, $filename, $ext, $resize);
                    $view['return_file_path'] = $return_file_path;
                } else {
                    $view['error'] = $attach->getError();
                }
            }
        }

        $this->render('img', $view);
    }

    /**
     * 生成各种规格大小图片
     * 处理后各种尺寸图片将以后缀区分
     * @static
     * @access public
     * @param string $directory_path 图片所在物理路径
     * @param string $filename 图片名称，不含路径
     * @param string $exe 文件后缀
     * @param string $strsize 对一个或多个规格再次自定义
     * @example
     */
    public function imgcut($directory_path, $filename, $exe, $strsize = null) {
        $img_path = $directory_path . $filename . '.' . $exe;
        $image_original = Yii::app()->image->load($img_path);
        $image_width = $image_original->width;
        $image_height = $image_original->height;
        //原图长宽比
        $scale = round($image_width / $image_height, 4);
        $all_size = $this->reSize($strsize);
        //裁剪大小默认为原图大小
        $cut_width = $image_width;
        $cut_height = $image_height;
        //循环生成各种尺寸图片
        foreach ($all_size as $key => $s) {
            //横向图片限制最大宽度
            if ($image_width >= $image_height && $image_width > $s['width']) {
                $cut_width = $s['width'];
                $cut_height = intval($s['width'] / $scale);
            }
            //纵向图片限制最大高度
            elseif ($image_width < $image_height && $image_height > $s['height']) {
                $cut_height = $s['height'];
                $cut_width = intval($s['width'] * $scale);
            }
            $image_original->resize($cut_width, $cut_height);
            $save_path = $key == 'original' ? $directory_path . $filename . '.' . $exe : $directory_path . $filename . '_' . $key . '.' . $exe;
            $image_original->save($save_path);
        }
    }

    /**
     * 解析自定义图片规格，并返回合并后的尺寸数组
     * 多个尺寸用英文逗号隔开
     * @static
     * @access public
     * @param string $strsize 规格字符串形式
     * @return mixed 返回规格数组
     * @example getnewsize('mysize_300_300,original_1000_600,bmiddle_600_400)
     */
    public function reSize($strsize = null) {
        //基本规格
        $base_size = $this->config['size'];
        //解析自定义规格
        $newsize = array();
        if ($strsize) {
            foreach (explode(',', $strsize) AS $size) {
                $asize = explode('_', $size);
                if (count($asize) == 3) {
                    $newsize[$asize[0]] = array('width' => $asize[1], 'height' => $asize[2]);
                }
            }
        }
        //合并规格
        $newsize = array_merge($base_size, $newsize);
        return $newsize;
    }

}
