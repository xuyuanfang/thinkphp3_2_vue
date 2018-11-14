<?php

/**
 * 获取分页数据
 * @param unknown $totalcount
 * @param string $page
 * @param string $limit
 */
function getPageInfo($totalcount,$page = '1',$limit = '20'){
    $page = I('page',$page);
    $limit = I('limit',$limit);
    
    if ($page < 1){
        $page = '0';
    }

    $pageInfo = array();
    $totalpage = ceil($totalcount / $limit);
    if ($totalcount > $page * $limit) {
        $next = '1';
    } else {
        $next = '0';
    }
    //是否有下一页
    $pageInfo['next'] = $next."";
    //页码
    $pageInfo['page'] = htmlentities(strip_tags($page))."";
    //总页数
    $pageInfo['totalpage'] = $totalpage."";
    //总条数
    $pageInfo['totalcount'] = htmlentities(strip_tags($totalcount))."";
    //每页显示数
    $pageInfo['limit'] = $limit;
    $offset = ($page - 1) * $limit;
    //起始位置
    $pageInfo['offset'] = $offset < 1 ? '0' : $offset.''; 

    return $pageInfo;

}
/**
 * 输出json数据
 * @param array $data  数据
 * @param string $status 状态码
 * @param string $message 状态信息
 * @param array $pageInfo  页面信息
 */
function echoJson($data = array(),$status = '0000',$message = 'sucess',$pageInfo){

    $res = array(
            'status' => $status
            ,'message' => $message
            ,'data' => $data
    );
    
    if (isset($pageInfo) && $pageInfo){
        $res['pageInfo'] = $pageInfo;
    }

    $res = json_encode($res);
    echo  $res;
    exit();
}

