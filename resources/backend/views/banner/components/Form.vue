<template>
<div class="app-container">
    <el-form ref="form" :rules="rules" :model="form" label-position="left" label-width="150px" style="max-width: 500px;">
        <el-form-item label="title:" prop="title">
            <el-input v-model="form.title" ></el-input>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="submitForm('form')">立即创建</el-button>
            <el-button @click="resetForm('form')">重置</el-button>
        </el-form-item>
    </el-form>
</div>
</template>

<script>

    import {bannerCreate, bannerUpdate} from "@/api/banner";

export default {
    name: "BannerForm",
    props:{
        isEdit: {
            type: Boolean,
            default: false
        },
        form:{
            type:Object,
            default(){
                return {
                    title:''
                }
            }
        },
        rules:{
            type:Object,
            default(){
                return {
                }
            }
        }
    },
    created() {
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                   let promise = this.isEdit?bannerCreate():bannerUpdate()
                    promise.then(response=>{
                        let {data}=response

                    })
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
