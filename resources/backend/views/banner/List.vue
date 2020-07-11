<template>
<div class="app-container">
    <el-form :inline="true">
        <el-form-item label="关键词:">
            <el-input v-model="listQuery.keywords"></el-input>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" icon="el-icon-search" @click="handleFilter">搜索</el-button>
            <el-button type="primary" icon="el-icon-plus" @click="handleCreate">添加</el-button>
        </el-form-item>
    </el-form>
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row >
        <el-table-column label="id">
            <template slot-scope="scope">
                <span>{{ scope.row.id }}</span>
            </template>
        </el-table-column>

        <el-table-column label="操作">
            <template slot-scope="scope">
                <el-button type="primary" icon="el-icon-edit" @click="handleEdit">编辑</el-button>
                <el-button type="primary" icon="el-icon-delete" @click="handleDelete">删除</el-button>
            </template>
        </el-table-column>
    </el-table>
    <pagination v-show="total>0" :total="total" :limit="listQuery.limit" :page="listQuery.page" @pagination="getList"></pagination>
    <el-dialog :visible.sync="showForm">
        <banner-form :is-edit="editForm"></banner-form>
    </el-dialog>
</div>

</template>

<script>
import Pagination from "@/components/Pagination/index";
import {fetchList} from "@/api/banner";
import BannerForm from "@/views/banner/components/Form";

export default {
    name: "BannerList",
    components: { BannerForm, Pagination},
    data(){
        return {
            total:0,
            list:[],
            showForm:false,
            editForm:false,
            listLoading:false,
            listQuery:{
                page:1,
                limit:2,
                keywords:''
            },
        }
    },
    created() {
        this.getList();
    },
    methods:{

        handleFilter(){
            this.getList();
        },
        getList(){
            fetchList(this.listQuery).then(response=>{
                let {data} =response
                this.list=data;
            })
        },
        handleCreate(){
            this.showForm=true;
        },
        handleEdit(){

        },
        handleDelete(){

        }
    }

}
</script>

<style scoped>

</style>
