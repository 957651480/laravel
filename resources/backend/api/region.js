import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: 'admin/region',
    method: 'get',
    params: query,
  });
}
export function fetchTopList(query) {

  return request({
    url: '/admin/region/list/top',
    method: 'get',
    params: query
  })
}

export function fetchTree(query={}) {
  return request({
    url: 'admin/region/tree',
    method: 'get',
    params: query,
  });
}

export function fetchRegion(id) {
  return request({
    url: 'admin/region/detail/' + id,
    method: 'get',
  });
}


export function createRegion(data) {
  return request({
    url: 'admin/region/create',
    method: 'post',
    data,
  });
}

export function updateRegion(id,data) {
  return request({
    url: 'admin/region/update/'+id,
    method: 'post',
    data,
  });
}

export function deleteRegion(id) {
  return request({
    url: 'admin/region/delete/' + id,
    method: 'get',
  });
}

export function batchDelete(data) {

  return request({
    url: 'admin/region/batch/delete',
    method: 'post',
    data
  })
}