<template>
    <el-form ref="form" :rules="rules" :model="form" label-position="left" label-width="150px" style="max-width: 500px;">
        <el-tabs v-model="tabActiveIndex">
            <el-tab-pane label="基本设置" name="first">
                <el-form-item label="分类名:" prop="name">
                    <el-input v-model="form.name" show-word-limit maxlength="25"/>
                </el-form-item>
                <el-form-item label="父级栏目:" prop="parent_id" >
                    <el-cascader v-model="form.parent_id"
                                 :options="parentOptions"
                                 :props="parentIdProps"

                    ></el-cascader>
                </el-form-item>
                <el-form-item  label="简介:">
                    <el-input v-model="form.desc"  type="textarea"  placeholder="请输入简介" />
                </el-form-item>
                <el-form-item label="状态:" prop="show">
                    <custom-element-switch v-model="form.show"></custom-element-switch>
                </el-form-item>

                <el-form-item label="排序:" prop="sort">
                    <el-input-number
                            v-model="form.sort"
                            controls-position="right"
                            :min="0" :max="100000"
                            placeholder="排序越大越靠前"
                    >
                    </el-input-number>
                    <span>(排序越大越靠前)</span>
                </el-form-item>
            </el-tab-pane>
            <el-tab-pane label="SEO设置" name="second">
                <el-form-item  label="简介:">
                    <el-input v-model="form.seo_title"    placeholder="请输入简介" />
                </el-form-item>
                <el-form-item  label="简介:">
                    <el-input v-model="form.seo_keyword"    placeholder="请输入简介" />
                </el-form-item>
                <el-form-item  label="简介:">
                    <el-input v-model="form.seo_description"  type="textarea"  placeholder="请输入简介" />
                </el-form-item>
            </el-tab-pane>

        </el-tabs>

    </el-form>
</template>

<script>
    import {create, update} from "@/api/category";
    import {httpSuccess} from "@/utils/message";
    import CustomElementSwitch from "@/components/Element/Switch/CustomElementSwitch";

    export default {
        name: "Form",
        components: {CustomElementSwitch },
        props:{
          form:{
              type:Object,
              default:{},
          }
        },
        data(){
            return{
                tabActiveIndex:'first',
                formCreating:false,
            }
        },
        methods:{
            create() {
                create(this.form)
                    .then(response => {
                        httpSuccess(response);
                        this.dialogFormVisible = false;
                        this.handleFilter();
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.formCreating = false;
                    });
            },
            update() {
                let id = this.form.id;
                update(id, this.form)
                    .then(response => {
                        httpSuccess(response);
                        this.dialogFormVisible = false;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.formCreating = false;
                    });
            },
        }
    }
</script>

<style scoped>

</style>