<template>
    <div v-loading="Creating" class="form-container">
        <el-form ref="form" :rules="rules" :model="form" label-position="left" label-width="150px" style="max-width: 500px;">
            <el-form-item label="标题:" prop="title">
                <el-input v-model="form.title" show-word-limit maxlength="25"/>
            </el-form-item>
            <el-form-item label="状态:" prop="show">
                <el-radio v-model="form.show" :label="10">显示</el-radio>
                <el-radio v-model="form.show" :label="20">隐藏</el-radio>
            </el-form-item>
            <el-form-item label="排序:" prop="sort">
                <el-input-number v-model="form.sort"></el-input-number>
                <span>排序越大越靠前</span>
            </el-form-item>
            <el-button type="primary" @click="submitForm('gr')">立即创建</el-button>
            <el-button @click="resetForm('form')">重置</el-button>
        </el-form>
    </div>
</template>

<script>
    export default {
        name: "Form",
        props:{
          isEdit:{
              type:Boolean,
              default:false
          }
        },
        data(){
            return {
                Creating:false,
            }
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        alert('submit!');
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
        }
    }
</script>

<style scoped>

</style>
