import request from '@/utils/request'

export function fetchList(query) {

    return request({
        url: '/admin/banner/list',
        method: 'get',
        params: query
    })
}
