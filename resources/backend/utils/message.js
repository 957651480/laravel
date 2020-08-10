import Vue from "vue";

export function message(options) {
    Vue.prototype.$message(options)
}
export function success(options={
    message: '成功',
    type: 'success',
    duration: 5 * 1000,
}) {
    message(options)
}

export function fail(options={
    message: '失败',
    type: 'error',
    duration: 5 * 1000,
}) {
    message(options)
}
export function warning(options={
    message: '警告',
    type: 'warning',
    duration: 5 * 1000,
}) {
    message(options)
}
