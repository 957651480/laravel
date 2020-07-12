<template>
    <div v-loading="Creating" class="form-container">
        <el-form ref="form" :rules="rules" :model="value" label-position="left" label-width="150px" style="max-width: 500px;">
            <el-form-item label="标题:" prop="title">
                <el-input v-model="value.title" show-word-limit maxlength="25"/>
            </el-form-item>
            <el-form-item label="状态:" prop="show">
                <el-radio v-model="value.show" :label="10">显示</el-radio>
                <el-radio v-model="value.show" :label="20">隐藏</el-radio>
            </el-form-item>
            <el-form-item label="排序:" prop="sort">
                <el-input-number v-model="value.sort"></el-input-number>
                <span>排序越大越靠前</span>
            </el-form-item>
            <el-button type="primary" @click="submitForm('form')">立即创建</el-button>
            <el-button @click="resetForm('form')">重置</el-button>
        </el-form>
    </div>
</template>

<script>
    import request from '@/utils/request'
    export default {
        name: "BannerForm",
        props:{
            value: {
                type: Object,
                default(){return {}}
            },
          action:{
            required:true,
            type:String
          },
          isEdit:{
              type:Boolean,
              default:false
          },
          rules:{
              type:Object,
              default(){return {}}
          }
        },
        data(){
            return {
                Creating:false,
            }
        },
        watch :{
            isEdit: function (val) {
                this.isEdit = val;
            },
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        let url = this.isEdit?this.action+'/update/'+this.form.id:this.action+'/create';
                        let data = this.value
                        request({url: url, method: 'post', data})
                            .then(response => {
                            this.$message({
                                message: '成功',
                                type: 'success',
                                duration: 5 * 1000,
                            });
                            this.$emit('form');
                        }).catch(error => {
                            console.log(error);
                        })
                        .finally(() => {
                            this.BannerCreating = false;
                        });
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
