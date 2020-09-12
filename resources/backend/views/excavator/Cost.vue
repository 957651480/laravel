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
                添加分组
            </el-button>

        </el-form>

        <el-table
                ref="table" v-loading="tableLoading" :data="list"
                :tree-props="{children: 'children', hasChildren: 'hasChildren'}"
                border
                default-expand-all
                row-key="id"
                style="width: 100%">
            <el-table-column  label="分类名" prop="name"></el-table-column>

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
                        添加子项
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
                <el-form ref="form" :rules="rules" :model="form" label-position="left" label-width="100px">
                    <el-form-item :label="showNameLabel(form.parent_id)" prop="name">
                        <el-input v-model="form.name" show-word-limit maxlength="25"/>
                    </el-form-item>
                    <el-form-item v-if="form.parent_id>0" label="分组名:" prop="parent_id">
                        <el-cascader v-model="form.parent_id"
                                     :options="normalizedParentOption"
                                     :props="parentIdProps"

                        ></el-cascader>
                    </el-form-item>

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
    import {
        batchDelete,
        createExcavatorCost,
        deleteExcavatorCost,
        fetchTree,
        updateExcavatorCost
    } from '@/api/excavator-cost';
    import {confirmMessage, httpSuccess} from "@/utils/message";
    import CustomElementSwitch from "@/components/Element/Switch/CustomElementSwitch";
    import {deepClone, emptyArrayToUndefinedRecursive} from "@/utils";
    import defaultDialog from "@/utils/dialog";

    const defaultForm ={
    name: '',
    parent_id:0,
}
export default {
    name: 'ExcavatorCostList',
    components: {CustomElementSwitch },
    directives: { waves },
    data() {
        return {
            list: [],
            total: 0,
            tableLoading: false,
            downloading: false,
            formCreating: false,
            isAllSelect:false,
            query: {
                page: 1,
                limit: 15,
                name: '',
            },
            form: defaultForm,
            dialog:defaultDialog,
            rules: {
                name: [{ required: true, message: '名称必须', trigger: 'blur' }],
                parent_id: [{ required: true, message: '分组必选', trigger: 'blur' }],
            },
            parentOptions:[],
            parentIdProps:{
                value:'id',
                label:'name',
                disabled:'disabled',
                emitPath:false,
                checkStrictly: true
            },
        };
    },

    created() {
        this.getTree();
    },
    computed:{
        normalizedParentOption(){
            let parentOptions=deepClone(this.list);
            parentOptions = emptyArrayToUndefinedRecursive(parentOptions,'children')
            return parentOptions;
        },
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
            this.setDialog({title: '新增', type: 'add', visible: true});
        },
        handleEdit(index,row) {
            this.form = row;
            this.setDialog({title: '编辑', type: 'edit', visible: true});
        },
        handleCreateNode(index,row) {
            this.form.parent_id =row.id;
            this.setDialog({title: '新增子项', type: 'node', visible: true});
        },

        handleDelete(index,id) {
            confirmMessage('确定删除吗?').then(() => {
                deleteExcavatorCost(id).then(response => {
                    httpSuccess(response);
                    this.handleFilter();
                }).catch(error => {
                    console.log(error);
                });
            }).catch(() => {
            });
        },
        closeDialog() {
            this.initForm();
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
                        createExcavatorCost(this.form).then(response =>
                        {
                            httpSuccess(response);
                            this.initForm();
                            this.setDialog();
                            this.handleFilter();
                        })
                        .finally(() => {
                            this.formCreating = false;
                        });
                    break;
                    case 'edit':
                        let  id = this.form.id;
                        updateExcavatorCost(id,this.form)
                            .then(response => {
                                httpSuccess(response);
                                this.initForm();
                                this.setDialog();
                                this.handleFilter();
                            })
                            .finally(() => {
                                this.formCreating = false;
                            });
                    break;
                }
            });
        },
        initForm() {
            /*if (this.$refs.form) {
                this.$refs.form.resetFields();
            }*/
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
            });
        },
        handleChange(index,data) {
            updateExcavatorCost(data.id,data).then(response => {
                httpSuccess(response);
            });
        },

        setDialog(options)
        {
            this.dialog=options?options:defaultDialog;
        },
        showNameLabel(parent_id){
            if(parent_id>0){
                return '费用子项名:'
            }
            return '分组名:';
        }
    }
};
</script>

<style lang="scss" scoped>

</style>
