<template>
    <div>
        <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row)">
            删除
        </el-button>
    </div>

</template>

<script>
    export default {
        name: "DeleteButton",
        methods:{
            handleDelete(){

            }
        }
    }
</script>

<style scoped>

</style>
