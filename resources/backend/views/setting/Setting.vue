<template>
    <div class="app-container">
        <el-form :model="form" label-position="left" label-width="80px">

            <el-form-item label="站点名称:">
                <el-input
                    type="text"
                    placeholder="请填写站点名称"
                    v-model="form.title"
                    maxlength="30"
                    show-word-limit
                >
                </el-input>
            </el-form-item>
            <el-form-item label="站点名称:">
                <el-input
                    type="text"
                    placeholder="请填写站点名称"
                    v-model="form.title"
                    maxlength="30"
                    show-word-limit
                >
                </el-input>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" >立即创建</el-button>
                <el-button >重置</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    name: "Setting",
    data(){
        return{
            form:{
                title:''
            }
        }
    }
}
</script>

<style scoped>

</style>
