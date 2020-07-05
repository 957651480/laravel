<template>
    <el-form :inline="true">
        <el-form-item label="关键词:">
            <el-input v-model="query.title" placeholder="请输入竞拍标题" clearable   class="filter-item"/>
        </el-form-item>
    </el-form>
</template>

<script>
    export default {
        name: "FileFilter"
    }
</script>

<style scoped>

</style>
