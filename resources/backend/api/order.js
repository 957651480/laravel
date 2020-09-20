import request from '@/utils/request'

export function fetchList(query) {

    return request({
        url: '/admin/order/list',
        method: 'get',
        params: query
    })
}

