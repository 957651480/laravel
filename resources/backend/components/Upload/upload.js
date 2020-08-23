import Vue from "vue";

export function sizeTip(file,size)
{
    if(!size)return true;
    let fileMb = file.size / 1024 / 1024 < 10;
    if(fileMb>size){
        Vue.prototype.$message.warning(`上传图片大小不能超过 ${size}MB!`);
        return false;
    }
    return true;
}

export function limitTip(fileList,limit)
{
    if(!limit) return true;
    Vue.prototype.$message.warning(`只能上传${limit}张图片`);
    return false;
}