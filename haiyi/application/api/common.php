<?php
/**
 * 图片加前缀
 * @param $images
 * @return mixed
 */
function array_url($images)
{
    foreach ($images as $key=>$val)
    {
        if($val != ""){
            $images[$key] = request()->domain().$val;
        }else{
            unset($images[$key]);
        }
    }
    return array_values($images);
}