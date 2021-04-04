<?php
function guid(){

    if (function_exists('com_create_guid')){

        return com_create_guid();

    }else{

        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.

        $charid = strtoupper(md5(uniqid(rand(), true)));

        $hyphen = chr(45);// "-"

        $uuid = chr(123)// "{"

            .substr($charid, 0, 8)

            .substr($charid, 8, 4)

            .substr($charid,12, 4)

            .substr($charid,16, 4)

            .substr($charid,20,12)

            .chr(125);// "}"

        return $uuid;

    }

}
if (! function_exists('api_response')) {

    /**
     * @param array $data
     * @return \App\Library\ApiResponse
     */
    function api_response(array $data=[])
    {
        return app(\App\Library\ApiResponse::class);
    }
}
if (! function_exists('get_sons')) {
    function get_sons($data, $parent_id = 0, string $pIdName = 'parent_id')
    {
        $sons = [];
        foreach ($data as $key=>$item) {
            if ($item[$pIdName] == $parent_id)
                $sons[] = $item;
                unset($data[$key]);
        }
        return $sons;
    }
}

if (! function_exists('get_subs_recursive'))
{
    function get_subs_recursive(array $data,int $parent_id=0,$level=1,string $pkName = 'id', string $pIdName = 'parent_id'){
        $subs=array();
        foreach($data as $key=>$item){
            if($item[$pIdName]==$parent_id){
                $item['level']=$level;
                $subs[]=$item;
                unset($data[$key]);
                $subs=array_merge($subs,get_subs_recursive($data,$item[$pkName],$level+1));

            }
        }
        return $subs;
    }
}

if (! function_exists('get_parents'))
{
    function get_parents(array $data, int $parent_id,string $pkName = 'id', string $pIdName = 'parent_id'){
        $parents=array();
        while($parent_id != 0){
            foreach($data as $key=>$item){
                if($item[$pkName]==$parent_id){
                    $parents[]=$item;
                    $parent_id=$item[$pIdName];
                    unset($data[$key]);
                    break;
                }
            }
        }
        return $parents;
    }
}
if (! function_exists('arr_to_tree_recursive'))
{
    /**
     * 采用递归将数据列表转换成树
     *
     * @param  array   $data   数据列表
     * @param  integer $rootId    根节点ID
     * @param  integer $level    根节点ID
     * @param  string  $pkName    主键
     * @param  string  $pIdName   父节点名称
     * @param  string  $childName 子节点名称
     *
     * @return array  转换后的树
     */
    function arr_to_tree_recursive(array $data, int $rootId = 0,int $level=1, string $pkName = 'id', string $pIdName = 'parent_id', string $childName = 'children')
    {
        $arr = [];
        foreach ($data as $sorData)
        {
            if ($sorData[$pIdName] == $rootId)
            {
                $sorData['level']=$level;
                $level++;
                $sorData[$childName] = arr_to_tree_recursive($data, $sorData[$pkName],$level);
                $sorData['has_children']=$sorData[$childName]?1:0;
                $arr[]               = $sorData;
            }
        }
        return $arr;
    }

}
