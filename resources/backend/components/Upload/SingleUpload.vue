<template>
<div v-bind="$attrs" class="single-upload">
    <el-upload
            class="avatar-uploader"
            :ref="$attrs.ref"
            v-bind="uploadAttrs"
            v-on="$listeners"
            :action="action"
            :headers="header"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload">
        <img v-if="elFileUrl" :src.sync="elFileUrl" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
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
        "show-file-list":{
            type:Boolean,
            default:false
        },
        extension: {
            type: Array,
            default(){
                return []
            }
        },
        size: {
            type: Number,
            default: 0
        },
        file_url:{
            type:String,
            default:''
        }
    },
    data() {
        return {
            uploadAttrs:{},
            elFileUrl:this.file_url
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
        handleAvatarSuccess(res, file) {
            let {data}=file.response;

            this.elFileUrl=data.url;
            this.$emit('input',data.id);
            this.$emit('update:file_url',data.url);

        },
        beforeAvatarUpload(file) {
            let length = this.extension.length;
            if (length) {
                let allow_extension = this.extension.some(item=>{
                    return item===file.type;
                });
                if(!allow_extension){
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                    return false;
                }
            }
            if (this.size) {
                if(file.size>this.size){
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                    return false;
                }

            }
            return true;
        },


    }
}
</script>

<style >
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
