<template>
<div v-bind="$attrs" class="single-upload">
    <el-upload
            :ref="$attrs.ref"
            v-bind="uploadAttrs"
            v-on="$listeners"
            :action="action"
            :headers="header"
            :accept="accept"
            :limit="limit"
            :list-type="listType"
            :on-preview="handlePictureCardPreview"
            :on-remove="handleRemove"
            :on-success="handleSuccess"
            :on-exceed="handleExceed"
            :before-upload="beforeUpload">
        <i  class="el-icon-plus"></i>
    </el-upload>
    <el-dialog :visible.sync="dialogVisible">
        <img width="100%" :src="elFileUrl" alt="">
    </el-dialog>
</div>

</template>

<script>
    import {getToken} from "@/utils/auth";

    export default {
    name: "SingleUpload",
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
        file_url:{
            type:String,
            default:''
        },
        limit:{
            type:Number,
            default:1
        },
        listType:{
            type:String,
            default:'picture-card'
        }
    },
    data() {
        return {
            uploadAttrs:{},
            elFileUrl:this.file_url,
            dialogImageUrl: '',
            dialogVisible: false
        };
    },
    watch:{
        file_url(val){
            this.elFileUrl=this.file_url;
        }
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
        handleSuccess(res, file) {
            let {data}=file.response;

            this.elFileUrl=data.url;
            this.$emit('input',data.id);
            this.$emit('update:file_url',data.url);

        },
        beforeUpload(file) {
            if (this.size) {
                let fileMb = file.size / 1024 / 1024 < 10;
                if(fileMb>this.size){
                    this.$message.warning(`上传图片大小不能超过 ${this.size}MB!`);
                    return false;
                }

            }
            return true;
        },
        handleRemove(file, fileList) {
            this.$emit('input',null);
            this.$emit('update:file_url','');
            console.log(file, fileList);
        },
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file.url;
            this.dialogVisible = true;
        },
        handleExceed(files, fileList){
            this.$message.warning(`只能上传${this.limit}张图片`);
            return false;
        }
    }
}
</script>

<style >
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
