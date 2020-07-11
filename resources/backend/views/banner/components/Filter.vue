<template>
<div class="app-container">
    <el-form :inline="true">
        <el-form-item v-for="(item,key) in value") :key="key" :label="item.label">
            <el-input v-model="item.name"></el-input>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" icon="el-icon-search" @click="handleFilter">搜索</el-button>
            <el-button type="primary" icon="el-icon-plus" @click="handleCreate">添加</el-button>
        </el-form-item>
    </el-form>
</div>
</template>

<script>
function noop() {}
export default {
    name: "BannerFilter",
    props:{
        value:{
          type:Array,
          default(){
              return[]
          }
        },
        handleFilter:{
            type:Function,
            default:noop
        }
    },
    methods:{
        handleCreate(){
            this.$emit('handleCreate');
        }
    }
}
</script>

<style scoped>

</style>
