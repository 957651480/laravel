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
                <el-button type="primary">上传<i class="el-icon-upload el-icon--right"></i></el-button>
            </el-col>
        </el-row>
        <el-row class="padding-content">
            <el-col :span="8" v-for="(o, index) in 2" :key="o" :offset="index > 0 ? 2 : 0">
                <el-card :body-style="{ padding: '0px' }">
                    <img src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png" class="image">
                    <div style="padding: 14px;">
                        <span>好吃的汉堡</span>
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
                this.list = response.data.items
                this.total = response.data.total
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
