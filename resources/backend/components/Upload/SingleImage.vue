<template>
<div v-bind="$attrs" class="single-image">
    <el-upload
            class="avatar-uploader"
            ref="upload"
            v-bind="uploadAttrs"
            v-on="$listeners"
            :action="action"
            :headers="header"
            :accept="accept"
            :multiple="false"
            :show-file-list="false"
            :on-success="handleSuccess"
            :before-upload="beforeUpload">

        <img v-if="elFileUrl" :src="elFileUrl" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
</div>

</template>

<script>
    import {getToken} from "@/utils/auth";

    import {sizeTip} from "@/components/Upload/upload";

    export default {
    name: "SingleImage",
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
    },
    data() {
        return {
            uploadAttrs:{},
            elFileUrl:this.file_url,
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
            this.$emit('input',data.id);
            this.$emit('update:file_url',data.url);
            this.$refs.upload.clearFiles();
        },
        beforeUpload(file) {
            return sizeTip(file,this.size);
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
