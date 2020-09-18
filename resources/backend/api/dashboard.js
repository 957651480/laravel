import request from '@/utils/request'

export function fetchPaneGroupList(query) {

    return request({
        url: '/admin/dashboard/panel/group/list',
        method: 'get',
        params: query
    })
}

