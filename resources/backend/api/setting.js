import request from '@/utils/request'

export function fetchSetting() {
  return request({
    url: '/admin/setting/detail',
    method: 'get',
  })
}




export function saveSetting(data) {
  return request({
    url: '/admin/setting/save',
    method: 'post',
    data
  })
}
