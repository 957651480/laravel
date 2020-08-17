import Vue from "vue";

export function beforeUpload(file,extension,size) {
    let length = extension.length;
    if (length) {
        let allow_extension = extension.some(item=>{
            return item===file.type;
        });
        if(!allow_extension){
            Vue.prototype.$message.error('上传头像图片只能是 JPG 格式!');
            return false;
        }
    }
    if (size) {
        if(file.size>size){
            Vue.prototype.$message.error('上传头像图片大小不能超过 2MB!');
            return false;
        }

    }
    return true;
}

export const defaultUploadAttrs = {
    action:"/api/admin/file/upload",
    headers:null,
    multiple:null,
    data:null,
    name:"file",
    "with-credentials":false,
    "show-file-list":true,
    drag:false,
    accept:null,
    "on-preview":function () {},
    "on-remove":function () {},

    "on-error":function () {},
    "on-progress":function () {},
    "on-change":function () {},
    "before-upload":function(){},
    "before-remove":function () {},
    "list-type":"text",
    "file-list":[],
    "http-request":function () {},
    "disabled":false,
    "limit":null,
    "on-exceed":null,
};