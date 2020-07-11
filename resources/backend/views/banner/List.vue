<template>
<div class="app-container">

    <el-form :inline="true">

        <el-form-item>
            <el-button type="primary" @click="handleFilter">查询</el-button>
        </el-form-item>
    </el-form>
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row >
        <el-table-column label="id">
            <template slot-scope="scope">
                <span>{{ scope.row.id }}</span>
            </template>
        </el-table-column>
    </el-table>
    <pagination v-show="total>0" :total="total" :limit="listQuery.limit" :page="listQuery.page" @pagination="getList"></pagination>
</div>

</template>

<script>
import Pagination from "@/components/Pagination/index";
import {fetchList} from "@/api/banner";
export default {
    name: "BannerList",
    components: {Pagination},
    data(){
        return {
            total:0,
            list:[],
            listLoading:false,
            listQuery:{
                page:1,
                limit:2
            }
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
        }
    }

}
</script>

<style scoped>

</style>
