<template>
<div v-bind="$attrs" class="multiple-upload">
    <el-upload
            :ref="$attrs.ref"
            v-bind="uploadAttrs"
            v-on="$listeners"
            :action="action"
            :file-list="fileList"
            :before-upload="handleBeforeUpload"
            :on-success="handleSuccess"
            >
        <i class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
</div>
</template>

<script>
    export default {
    name: "MultipleUpload",
    props:{

        value:{
            type:Array,
            default:[]
        },
        action:{
            type:String,
            default:'/api/admin/file/upload'
        },
        file_urls:{
            type:Array,
            default:[]
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
    },

    data() {
        return {
            uploadAttrs: {},
            fileIds:this.value,
            fileList:this.file_urls,
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
        value(val){
          this.fileIds=this.value;
        },
        file_urls(val){
            this.fileList=this.file_urls;
        }
    },
    methods: {
        init() {
            this.uploadAttrs = this.$attrs;
        },
        handleSuccess(res, file) {
            if(this.onSuccess){
                return this.onSuccess(res, file, this.uploadFiles);
            }
            let {data}=res;
            this.fileIds.push(data.id);
            this.fileList.push(data.url);
            this.$emit('input',this.fileIds);
            this.$emit('update:file_urls',this.fileList);

        },
        handleBeforeUpload(file) {
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
        handleRemove(file) {
            console.log(file);
        },
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file.url;
            this.dialogVisible = true;
        },
        handleDownload(file) {
            console.log(file);
        }
    }
}
</script>

<style scoped>

</style>