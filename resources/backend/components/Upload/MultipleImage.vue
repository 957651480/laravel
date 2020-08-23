<template>
<div v-bind="$attrs" class="multiple-image">
    <el-upload
            :ref="$attrs.ref"
            v-bind="uploadAttrs"
            v-on="$listeners"
            :action="action"
            :headers="header"
            :accept="accept"
            :before-upload="handleBeforeUpload"
            :on-exceed="handleExceed"
            :on-success="handleSuccess"
            >
        <i slot="default" class="el-icon-plus "></i>
        <div slot="tip" class="el-upload__tip">建议上传png格式图片</div>
    </el-upload>
</div>
</template>

<script>
    import {getToken} from "@/utils/auth";
    import {limitTip, sizeTip} from "@/components/Upload/upload";

    export default {
    name: "MultipleImage",
    props:{
        action:{
            type:String,
            default:'/api/admin/file/upload'
        },
        header:{
            type:Object,
            default(){
                return { Authorization: 'Bearer ' + getToken() }
            }
        },
        accept: {
            type: String,
            default:'.png,.jpg,.jpeg,.bmp'
        },
        size: {
            type: Number,
            default: 0
        },
    },

    data() {
        return {
            uploadAttrs: {},
            dialogVisible: false,
            disabled: false
        };
    },
    created(){
        this.$nextTick(() => {
            this.init()
        })
    },
    methods: {
        init() {
            this.uploadAttrs = this.$attrs;
        },
        handleSuccess(res, file,fileList) {

            let ids=[];
            let file_urls=[];
            fileList.forEach((item)=>{
                ids.push(item.response.data.id);
                file_urls.push(item.response.data.url);
            });
            this.$emit('input',ids);
            this.$emit('update:file-list',file_urls);

        },
        handleBeforeUpload(file) {
            return sizeTip(file,this.size);
        },
        handleRemove(file) {
            console.log(file);
        },
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file.url;
            this.dialogVisible = true;
        },
        handleDownload(file) {
            console.log(file);
        },
        handleExceed(files, fileList){
            return  limitTip(fileList,this.limit)
        }
    }
}
</script>

<style scoped>

</style>