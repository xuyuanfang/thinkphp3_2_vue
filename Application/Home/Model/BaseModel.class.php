<?php
namespace Home\Model;

use Think\Model;

class BaseModel extends Model
{
    //分页数据
    protected $pageInfo = NULL;
    protected $offset = NULL;
    protected $limit = NULL;
    
    public function __construct(){
        parent::__construct();
        
    }
    
    /**
     * 设置分页数据
     * @param unknown $pageInfo
     */
    public function setPageInfo($pageInfo){
        $this->offset = isset($pageInfo['offset']) ? $pageInfo['offset'] : '0';
        $this->limit = isset($pageInfo['limit']) ? $pageInfo['limit'] : '20';
        $this->pageInfo = $pageInfo;
    }
    
    /**
     * 获取分页数据
     */
    public function getPageInfo(){
        return $this->pageInfo;
    }
     
}

?>