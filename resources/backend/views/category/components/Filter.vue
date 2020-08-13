<template>
    <el-form :inline="true" >
        <el-form-item label="轮播标题:">
            <el-input v-model="query.title" placeholder="请输入轮播标题" clearable style="width: 200px;" @change="handleFilter" class="filter-item" @keyup.enter.native="handleFilter" />
        </el-form-item>
        <el-button v-waves type="primary" icon="el-icon-search" @click="handleFilter">
            搜索
        </el-button>
        <el-button type="primary" icon="el-icon-plus" @click="handleCreate">
            添加顶级栏目
        </el-button>

    </el-form>
</template>

<script>
    export default {
        name: "Filter",
        props:{
            query:{
                type:Object,
                default:{}
            }
        }
    }
</script>

<style scoped>

</style>