<template>
    <div class="app-container">
        <el-form :model="form" label-position="left" label-width="80px">


            <el-form-item label="服务保障:">
                <el-tag
                        :key="tag"
                        v-for="tag in form.serviceEnsure"
                        closable
                        :disable-transitions="false"
                        @close="handleClose(tag)">
                    {{tag}}
                </el-tag>
                <el-input
                        class="input-new-tag"
                        v-if="inputVisible"
                        v-model="inputValue"
                        ref="saveTagInput"
                        size="small"
                        @keyup.enter.native="handleInputConfirm"
                        @blur="handleInputConfirm"
                >
                </el-input>
                <el-button v-else class="button-new-tag" size="small" @click="showInput">+添加</el-button>
            </el-form-item>

            <el-form-item label="期货介绍:" prop="future_desc" >
                <Tinymce ref="editor" v-model="form.future_desc" :height="400" />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submit">保存</el-button>
                <el-button @click="reset">重置</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import Tinymce from '@/components/Tinymce'
    import {fetchSetting,saveSetting} from "@/api/setting";
    import {httpSuccess} from "@/utils/message";

    const defaultForm={}

export default {
    name: "Setting",
    components: {Tinymce},
    data(){
        return{
            form:{
                future_desc:'',
                serviceEnsure:[]
            },
            inputVisible: false,
            inputValue: ''
        }
    },
    created() {
        this.fetchData()
    },
    methods:{
        fetchData(){
            fetchSetting().then(response => {
                this.defaultForm = response.data
                this.form = response.data
            })
        },
        handleClose(tag) {
            this.form.serviceEnsure.splice(this.form.serviceEnsure.indexOf(tag), 1);
        },

        showInput() {
            if(this.form.serviceEnsure.length>=4){
                this.$message({
                    message: '不能超过4项',
                    type: 'warning'
                })
                return false
            }
            this.inputVisible = true;
            this.$nextTick(_ => {
                this.$refs.saveTagInput.$refs.input.focus();
            });
        },

        handleInputConfirm() {
            let inputValue = this.inputValue;
            if (inputValue) {
                this.form.serviceEnsure.push(inputValue);
            }
            this.inputVisible = false;
            this.inputValue = '';
        },
        submit(){
            saveSetting(this.form).then(response =>
            {
                httpSuccess(response);
            })
        },
        reset(){
            this.form=JSON.parse(JSON.stringify(defaultForm))
        }
    },
}
</script>

<style >
    .el-tag + .el-tag {
        margin-left: 10px;
    }
    .button-new-tag {
        margin-left: 10px;
        height: 32px;
        line-height: 30px;
        padding-top: 0;
        padding-bottom: 0;
    }
    .input-new-tag {
        width: 90px;
        margin-left: 10px;
        vertical-align: bottom;
    }
</style>
