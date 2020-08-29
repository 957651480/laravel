<template>
<div v-bind="$attrs" class="multiple-image">
    <el-upload
            :ref="$attrs.ref"
            v-bind="uploadAttrs"
            v-on="$listeners"
            :action="action"
            v-model="value"
            :headers="header"
            :accept="accept"
            :list-type="listType"
            :file-list="elFileList"
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
        value:{
            type:Array,
            default:[]
        },
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
        listType:{
            type:String,
            default:'picture-card'
        },
        file_urls:{
            type:Array,
            default:[]
        }
    },

    data() {
        return {
            uploadAttrs: {},
            elFileList:this.file_urls,
            dialogVisible: false,
            disabled: false
        };
    },
    created(){
        this.$nextTick(() => {
            this.init()
        })
    },
    watch:{
        file_urls(val){
            this.elFileList=this.file_urls;
        }
    },
    methods: {
        init() {
            this.uploadAttrs = this.$attrs;
        },
        handleSuccess(response, file) {
            let ids=this.value;
            let fileList=this.elFileList;
            this.$emit('input',ids.push(response.data.id));
            this.$emit('update:file_urls',fileList.push(response.data.url));
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