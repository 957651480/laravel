<template>
    <div class="app-container">
        <el-form :inline="true">
            <el-form-item label="jkdshfkjds">
                <el-input></el-input>
            </el-form-item>
        </el-form>
        <ul class="el-upload-list el-upload-list--picture-card">
            <li tabindex="0" class="el-upload-list__item is-uploading"><!----><a class="el-upload-list__item-name"><i
                class="el-icon-document"></i>timg.jpg
            </a><label class="el-upload-list__item-status-label"><i
                class="el-icon-upload-success el-icon-check"></i></label><i class="el-icon-close"></i><i
                class="el-icon-close-tip">按 delete 键可删除</i>
                <span class="el-upload-list__item-actions"><span class="el-upload-list__item-preview"><i
                    class="el-icon-zoom-in"></i></span><span class="el-upload-list__item-delete"><i
                    class="el-icon-delete"></i></span></span></li>
        </ul>

        <pagination></pagination>
    </div>

</template>

<script>
    import Pagination from "@/components/Pagination";


    import {fetchList, fetchFile} from "@/api/file";


    export default {
        name: "FileList",
        components: { Pagination },
        data() {
            return {
                list: null,
                total: 0,
                listLoading: true,
                listQuery: {
                    page: 1,
                    limit: 20
                },
                urls: [
                    'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
                    'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
                    'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
                    'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
                    'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
                    'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
                    'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
                    'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
                ]
            }
        },
        created() {
            this.getList();
        },
        methods: {
            getList() {
                this.listLoading = true
                fetchList(this.listQuery).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            }
        }
    }
</script>

<style scoped>

</style>
