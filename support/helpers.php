<?php
if (! function_exists('api_response')) {

    /**
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return \App\Http\Response\ApiResponse|\Illuminate\Http\JsonResponse
     */
    function api_response(array $response=[])
    {
        $factory = app(\App\Http\Response\ApiResponse::class);
        if (func_num_args() === 0) {
            return $factory;
        }
        return $factory->json($response);
    }
}
if (! function_exists('getSons')) {
    function getSons($data, $parent_id = 0, string $pIdName = 'parent_id')
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

if (! function_exists('getParents'))
{
    function getParents(array $data, int $parent_id,string $pkName = 'id', string $pIdName = 'parent_id'){
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
     * @param  string  $pkName    主键
     * @param  string  $pIdName   父节点名称
     * @param  string  $childName 子节点名称
     *
     * @return array  转换后的树
     */
    function arr_to_tree_recursive(array $data, int $rootId = 0, string $pkName = 'id', string $pIdName = 'parent_id', string $childName = 'children')
    {
        $arr = [];
        foreach ($data as $sorData)
        {
            if ($sorData[$pIdName] == $rootId)
            {
                $sorData[$childName] = arr_to_tree_recursive($data, $sorData[$pkName]);
                $arr[]               = $sorData;
            }
        }
        return $arr;
    }

}