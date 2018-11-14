<?php
namespace Home\Model;

use Think\Model;
use Think\Cache;
class RoleModel extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }

    /**
     * 获取角色列表
     *
     * @return mixed
     */
    public function getNodeList ($userid)
    {
        $nodeList = array();
        $cache = new Cache();
        $cacheInstance = $cache->getInstance();
        $key = "nodelist_{$userid}";
        $expire = 24*60*60;
        $nodeList = $cacheInstance->get($key);
        if ($nodeList){
            return $nodeList;
        }else {
             $roleModel  = new RoleModel();
             $roleList = $roleModel->getRoleList($userid);
             //管理员显示所有权限
             if ($roleModel->isAdmin($userid,$roleList)){
                 $node = M('Node');
                 $where['status'] = '1';
                
                 $nodedata = $node->where($where)->order('level ASC ')->select();
                 if ($nodedata){
                     $nodearr = array();
                     $nodelevel = array();
                     foreach ($nodedata as $key => $val){
                         $id = $val['id'];
                         $nodearr[$id] = $val;
                         
                         $name = $val['name'];
                         $title = $val['title'];
                         $pid = $val['pid'];
                         $level = $val['level'];
                         if ($level == '1'){
                             $nodearr[$id] = array();
                         }elseif ($level == '2'){
                             if (isset($nodelevel[$pid])){
                                 $nodelevel[$pid][$id] = array();
                             }
                         }elseif ($level == '3'){
                             if ($nodearr[$pid]){
                                 $ppid = $nodearr['pid'];
                                 if (isset($nodelevel[$ppid][$pid])){
                                     $nodelevel[$ppid][$pid][$id] = array();
                                 }
                             }
                         }
                     }
                     
                     if ($nodelevel){
                         foreach ($nodelevel as $key => $nodelevel1){
                              $node1 = $nodearr[$key];
                              if (!$nodelevel1){
                                  continue;
                              }
                              foreach ($nodelevel1 as $nodelevel1key => $nodelevel2) {
                                  $node2 = $nodearr[$nodelevel1key];
                                  if (!$nodelevel2){
                                      continue;
                                  }
                                  foreach ($nodelevel2 as $nodelevel2key => $nodelevel2value){
                                      $url = "{$node1['name']}/{$node2['name']}/{$nodelevel2value['name']}";
                                      //是否是vue模块
                                      if (isset($nodelevel2value['vue']) && $nodelevel2value['vue']){
                                          $isvue = "1";
                                      }else {
                                          $isvue = "0";
                                      }
                                      $nodelevel2value['isvue'] = $isvue;
                                      if ($isvue){
                                          $nodelevel2value['url'] = $nodelevel2value['vuepath'];
                                      }else {
                                          $nodelevel2value['url'] = $url;
                                      }
                                      
                                      $nodeList[] = $nodelevel2value;
   
                                  }
                              
                              }
                              
                         }
                     }
                     
                 }
                 
             }else {
                 $access = M('Access');
                 $where = array();
                 $where['status'] = '1';
                 $where['userid'] = $userid;
             }
             
             $where['level'] = '1';
         //    $access->
            
            
        }
        

    

    

    }

}

?>