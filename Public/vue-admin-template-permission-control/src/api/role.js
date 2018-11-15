import request from '@/utils/request'

export function roleList() {
    return request({
        url: 'http://localhost/thinkphp3_2_vue/index.php/Home/Role/roleList',
        method: 'get',
    });
}