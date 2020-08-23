<template>
<div v-bind="$attrs" class="single-image">
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
        <i slot="default" class="el-icon-plus"></i>
        <div slot="tip" class="el-upload__tip">建议上传png格式图片</div>
    </el-upload>
    <el-dialog :visible.sync="dialogVisible">
        <img width="100%" :src.sync="elFileUrl" alt="">
    </el-dialog>
</div>

</template>

<script>
    import {getToken} from "@/utils/auth";

    import {limitTip, sizeTip} from "@/components/Upload/upload";

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
            return sizeTip(file,this.size);
        },
        handleRemove(file, fileList) {
            this.$emit('input',null);
            this.$emit('update:file_url','');
        },
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file.url;
            this.dialogVisible = true;
        },
        handleExceed(files, fileList){
            return  limitTip(fileList,this.limit)
        }
    }
}
</script>

<style >
</style>
