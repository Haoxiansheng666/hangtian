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

/**
 * 计算两个经纬度之间的距离
 * @param $lat1
 * @param $long1
 * @param $lat2
 * @param $long2
 * @return array
 */
function getDistance($lat1, $long1, $lat2, $long2) {
    $theta = $long1 - $long2;
    $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat1)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    //英里
    $miles = $miles * 60 * 1.1515;
    //英尺
    $feet = $miles * 5280;
    //码
    $yards = $feet / 3;
    //千米
    $kilometers = $miles * 1.609344;
    //米
    $meters = $kilometers * 1000;
    return compact('miles','feet','yards','kilometers','meters');
}