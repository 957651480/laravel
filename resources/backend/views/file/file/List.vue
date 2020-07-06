<template>

<el-row class="file-manage">
    <el-col :span="6">
        <ul>
            <li>
                <a class="el-icon-edit"></a>
                <a>hjkhdsjkfkjjk</a>
                <a class="el-icon-delete"></a>
            </li>

        </ul>
    </el-col>
    <el-col :span="18">
        <el-row>
            <el-col :span="9" style="float: left">
                <el-button type="primary" icon="el-icon-remove">移动</el-button>
                <el-button type="primary" icon="el-icon-delete">删除</el-button>
            </el-col>
            <el-col :span="9" style="float: right">
                <el-upload
                    action="/api/admin/file/upload"
                    :show-file-list="false"
                    :on-success="handSuccess"
                    >
                    <el-button type="primary">上传<i class="el-icon-upload el-icon--right"></i></el-button>
                </el-upload>

            </el-col>
        </el-row>
        <el-row class="padding-content">
            <el-col :span="8" v-for="(item, index) in list" :key="item.id" >
                <el-card>
                    <img :src="item.url" class="image">
                    <div style="padding: 14px;">
                        <span>{{item.name}}</span>
                        <div class="bottom clearfix">
                            <time class="time">{{ currentDate }}</time>
                            <el-button type="text" class="button">操作按钮</el-button>
                        </div>
                    </div>
                </el-card>
            </el-col>
        </el-row>
    </el-col>
</el-row>
</template>

<script>
import Pagination from "@/components/Pagination";
import {fetchList, fetchFile} from "@/api/file";

export default {
    name: "FileList",
    components: {Pagination},
    props:[
        {

        }
    ],
    data() {
        return {
            list: null,
            total: 0,
            listLoading: true,
            listQuery: {
                page: 1,
                limit: 20
            },

        }
    },
    created() {
        this.getList();
    },
    methods: {
        getList() {
            this.listLoading = true
            fetchList(this.listQuery).then(response => {
                this.list = response.data
                this.total = response.total
                this.listLoading = false
            })
        },
        handSuccess(response, file, fileList){

        }
    }
}
</script>

<style scoped>
    .file-manage{
        width: 840px;
    }
    .file-manage > ul ,li{
        list-style-type: none;
    }

    .time {
        font-size: 13px;
        color: #999;
    }

    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }

    .button {
        padding: 0;
        float: right;
    }

    .image {
        width: 100%;
        display: block;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }
</style>
