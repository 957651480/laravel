import request from '@/utils/request'

export function fetchList(query) {

    return request({
        url: '/admin/reserve/list',
        method: 'get',
        params: query
    })
}


export function generateOrder(id,data) {

    return request({
        url: '/admin/reserve/generate/order/'+id,
        method: 'get',
        data
    })
}
