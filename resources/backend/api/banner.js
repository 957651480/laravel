import request from '@/utils/request'

export function fetchList(query) {

    return request({
        url: '/admin/banner/list',
        method: 'get',
        params: query
    })
}

export function bannerCreate(data) {

    return request({
        url: '/admin/banner/create',
        method: 'post',
        data
    })
}

export function bannerUpdate(id,data) {

    return request({
        url: '/admin/banner/update/'+id,
        method: 'post',
        data
    })
}
