import request from '@/utils/request'

export function fetchList(query) {

    return request({
        url: '/admin/visit/list',
        method: 'get',
        params: query
    })
}

export function deleteVisit(id) {

    return request({
        url: '/admin/visit/delete/'+id,
        method: 'get',
    })
}

export function batchDeleteVisit(data) {

    return request({
        url: '/admin/visit/batch/delete',
        method: 'post',
        data
    })
}
