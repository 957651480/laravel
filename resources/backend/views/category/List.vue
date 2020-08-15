<template>
    <div class="app-container">
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

        <el-table
                ref="table" v-loading="tableLoading" :data="list"
                :tree-props="{children: 'children', hasChildren: 'hasChildren'}"
                border
                default-expand-all
                row-key="id"
                style="width: 100%">
            <el-table-column  label="标题" prop="name"></el-table-column>

            <el-table-column align="center" label="显示">
                <template slot-scope="scope">
                    <custom-element-switch
                            v-model="scope.row.show"
                            @change="handleChange(scope.$index,scope.row)"
                    ></custom-element-switch>
                </template>
            </el-table-column>
            <el-table-column align="center" label="创建时间">
                <template slot-scope="scope">
                    <span>{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="操作" width="350" fixed="right">
                <template slot-scope="scope">
                    <el-button type="primary" size="small" icon="el-icon-plus" @click="handleCreateNode(scope.$index,scope.row)">
                        添加子栏目
                    </el-button>
                    <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEdit(scope.$index,scope.row)">
                        编辑
                    </el-button>
                    <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.$index,scope.row.id)">
                        删除
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog :title="dialog.title" :visible.sync="dialog.visible" @close='closeDialog'>
            <div v-loading="formCreating" class="form-container">
                <el-form ref="form" :rules="rules" :model="form" label-position="left" label-width="150px" style="max-width: 500px;">
                    <el-tabs v-model="tabActiveIndex">
                        <el-tab-pane label="基本设置" name="first">
                            <el-form-item label="分类名:" prop="name">
                                <el-input v-model="form.name" show-word-limit maxlength="25"/>
                            </el-form-item>
                            <el-form-item label="父级栏目:" prop="parent_id" >
                                <el-cascader v-model="form.parent_id"
                                             :options="normalizedParentOption"
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
                <div slot="footer" class="dialog-footer">
                    <el-button type="primary" @click="enterDialog()">
                        保存
                    </el-button>
                    <el-button @click="closeDialog()">
                        取消
                    </el-button>
                </div>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import waves from '@/directive/waves'; // Waves directive
    import {batchDelete, createCategory, deleteCategory, fetchTree, updateCategory} from '@/api/category';
    import {confirmMessage, httpSuccess} from "@/utils/message";
    import CustomElementSwitch from "@/components/Element/Switch/CustomElementSwitch";
    import {deepClone, emptyArrayToUndefinedRecursive} from "@/utils";

    const defaultDialog ={
    title:'',
    type:'',
    visible:false,
};
const defaultForm ={
    name: '',
    parent_id:null,
    desc: '',
    seo_title:'',
    seo_keyword:'',
    seo_description:'',
    show: 10,
}
export default {
    name: 'CategoryList',
    components: {CustomElementSwitch },
    directives: { waves },
    data() {
        return {
            list: [],
            total: 0,
            tableLoading: false,
            downloading: false,
            formCreating: false,
            tabActiveIndex:'first',
            query: {
                page: 1,
                limit: 15,
                name: '',
            },
            form: defaultForm,
            dialog:defaultDialog,
            rules: {
                name: [{ required: true, message: '标题必须', trigger: 'blur' }],
                image_id: [{ required: true, message: '图片必须', trigger: 'blur' }],
            },
            parentRootOptions: {
                id:"0",
                parent_id:"0",
                name: "顶级栏目"
            },
            parentOptions:[],
            parentIdProps:{
                value:'id',
                label:'name',
                disabled:'disabled',
                emitPath:false,
                checkStrictly: true
            }
        };
    },

    created() {
        this.getTree();
    },
    computed:{
        normalizedParentOption(){
            let parentOptions=deepClone(this.list);
            parentOptions = emptyArrayToUndefinedRecursive(parentOptions,'children')
            parentOptions.unshift(this.parentRootOptions);
            return parentOptions;
        }
    },
    methods: {
        async getTree() {
            this.tableLoading = true;
            const {data} = await fetchTree({parent_id: 0});
            this.list = data;
            this.tableLoading = false;
        },
        handleFilter() {
            this.getTree();
        },
        handleCreate()
        {
            this.initForm();
            this.form.parent_id = "0";
            this.setDialog({title: '新增', type: 'add', visible: true});
        },
        handleEdit(index,row) {
            this.form = row;
            this.setDialog({title: '编辑', type: 'edit', visible: true});
        },
        handleCreateNode(index,row) {
            this.form.parent_id =row.id;
            this.setDialog({title: '新增子栏目', type: 'node', visible: true});
        },

        handleDelete(index,id) {
            confirmMessage('确定删除吗?').then(() => {
                deleteCategory(id).then(response => {
                    httpSuccess(response);
                    this.handleFilter();
                }).catch(error => {
                    console.log(error);
                });
            }).catch(() => {
            });
        },
        closeDialog() {
            this.setDialog();
        },
        enterDialog() {
            this.$refs['form'].validate((valid) =>
            {
                if (!valid) return false;
                this.formCreating = true;
                switch (this.dialog.type) {
                    case 'add':
                    case 'node':
                        createCategory(this.form).then(response =>
                        {
                            httpSuccess(response);
                            this.setDialog();
                            this.handleFilter();
                        }).catch(error => {
                            console.log(error);
                        })
                        .finally(() => {
                            this.formCreating = false;
                        });
                    break;
                    case 'edit':
                        let  id = this.form.id;
                        updateCategory(id,this.form)
                            .then(response => {
                                httpSuccess(response);
                                this.setDialog();
                                this.handleFilter();
                            })
                            .catch(error => {
                                console.log(error);
                            })
                            .finally(() => {
                                this.formCreating = false;
                            });
                    break;
                }
            });
        },
        initForm() {
            if (this.$refs.form) {
                this.$refs.form.resetFields();
            }
            this.form = defaultForm;
        },

        handleBatchDelete() {

            let ids = [];
            this.multipleSelection.forEach(row => {
                ids.push(row.id)
            });
            batchDelete({ids: ids}).then(response => {
                httpSuccess(response);
                this.handleFilter();
            }).catch(error => {
                console.log(error);
            });
        },
        handleChange(index,data) {
            updateCategory(data.id,data).then(response => {
                httpSuccess(response);
            });
        },

        setDialog(options)
        {
            this.dialog=options?options:defaultDialog;
        }
    }
};
</script>

<style lang="scss" scoped>

</style>
