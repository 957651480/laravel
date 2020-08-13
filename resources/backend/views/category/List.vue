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

        <el-table ref="table" v-loading="tableLoading" :data="list" border fit highlight-current-row style="width: 100%"
                  @selection-change="handleSelectionChange"
        >
            <el-table-column
                type="selection"
                width="55">
            </el-table-column>
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>
            <el-table-column align="center" label="排序" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.sort }}</span>
                </template>
            </el-table-column>
            <el-table-column align="center" label="标题">
                <template slot-scope="{row}">
                    <span >{{ row.title }}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="显示">
                <template slot-scope="scope">
                    <el-switch
                        v-model="scope.row.show"
                        active-color="#13ce66"
                        inactive-color="#ff4949"
                        :active-value="10"
                        :inactive-value="20"
                        @change="handleChange(scope.row)"
                    >
                    </el-switch>
                </template>
            </el-table-column>
            <el-table-column align="center" label="创建时间">
                <template slot-scope="scope">
                    <span>{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="操作" width="350" fixed="right">
                <template slot-scope="scope">
                    <el-button type="primary" size="small" icon="el-icon-plus" @click="handleCopy(scope.row)">
                        添加子栏目
                    </el-button>
                    <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEdit(scope.row)">
                        编辑
                    </el-button>
                    <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id)">
                        删除
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-row >
            <el-col :span="12" style="float: left;padding-top: 20px">

                <el-button type="primary" size="small"  @click="toggleSelection(true)">
                    全选
                </el-button>
                <el-button type="primary" size="small"  @click="toggleSelection(false)">
                    取消
                </el-button>
                <el-button type="danger" size="small" icon="el-icon-delete" :disabled="batchDisabled" @click="handleBatchDelete()">
                    批量删除
                </el-button>
            </el-col>
        </el-row>
        <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getList" />
        <el-dialog v-model="isEdit" :title="isEdit?'编辑':'添加'" :visible.sync="dialogFormVisible" @close='closeDialog'>
            <div v-loading="formCreating" class="form-container">
                <el-form ref="form" :rules="rules" :model="form" label-position="left" label-width="150px" style="max-width: 500px;">
                    <el-form-item label="标题:" prop="name">
                        <el-input v-model="form.name" show-word-limit maxlength="25"/>
                    </el-form-item>
                    <el-form-item  label="简介:">
                        <el-input v-model="form.desc"  type="textarea"  placeholder="请输入简介" />
                    </el-form-item>
                    <el-form-item label="状态:" prop="show">
                        <el-switch
                            v-model="form.show"
                            active-color="#13ce66"
                            inactive-color="#ff4949"
                            :active-value="10"
                            :inactive-value="20"
                        >
                        </el-switch>
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
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button type="primary" @click="save()">
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
    import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
    import waves from '@/directive/waves'; // Waves directive
    import {batchDelete, create, destroy, fetchTopList, fetchTree, update} from '@/api/category';
    import {confirmMessage, httpSuccess} from "@/utils/message";

    export default {
        name: 'BannerList',
        components: {   Pagination },
        directives: { waves },
        data() {
            return {
                list: null,
                total: 0,
                tableLoading: true,
                downloading: false,
                formCreating: false,
                query: {
                    page: 1,
                    limit: 15,
                    name: '',
                },
                form: {},
                dialogFormVisible: false,
                rules: {
                    name: [{ required: true, message: '标题必须', trigger: 'blur' }],
                    image_id: [{ required: true, message: '图片必须', trigger: 'blur' }],
                },
                isEdit: false,
                multipleSelection: [],
            };
        },
        computed: {
            batchDisabled:function() {
                return this.multipleSelection.length === 0
            },
        },
        created() {
            this.resetForm();
            this.getList();

            this.getTree();
        },
        methods: {
            async getList() {
                const { limit, page } = this.query;
                this.tableLoading = true;
                const { total,data } = await fetchTopList(this.query);
                this.list = data;
                this.list.forEach((element, index) => {
                    element['index'] = (page - 1) * limit + index + 1;
                });
                this.total = total;
                this.tableLoading = false;
            },
            async getTree() {
                const { data } = await fetchTree({parent_id:0});
                this.tree = data;
            },
            handleFilter() {
                this.query.page = 1;
                this.getList();
            },
            handleCreate() {
                this.resetForm();
                this.dialogFormVisible = true;
                this.$nextTick(() => {
                    this.$refs['form'].clearValidate();
                });
            },
            handleEdit(data){
                this.form = data;
                this.isEdit = true;
                this.dialogFormVisible = true;
            },
            handleCopy(data){
                this.form = data;
                this.create();
            },
            handleDelete(id) {
                confirmMessage('确定删除吗?').then(() => {
                    destroy(id).then(response => {
                        httpSuccess(response);
                        this.handleFilter();
                    }).catch(error => {
                        console.log(error);
                    });
                }).catch(() => {
                });
            },
            create(){
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
            update(){
                let  id = this.form.id;
                update(id,this.form)
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
            save() {
                this.$refs['form'].validate((valid) => {
                    if (!valid) return false;
                    this.formCreating = true;
                    this.isEdit?this.update():this.create()
                });
            },
            resetForm() {

                this.form = {
                    name: '',
                    desc: '',
                    image_id:null,
                    image_url:null,
                    show: 10,
                    sort: 0,
                };
            },
            showImageList(imageList){
                let tmpList = [];
                for (let i = 0;i < imageList.length;i++){
                    tmpList[i]=imageList[i].url;
                }
                return tmpList;
            },
            handleDownload(){

            },
            closeDialog(){
                this.isEdit=false;
                this.dialogFormVisible = false;
            },
            handleBatchDelete(){

                let ids=[];
                this.multipleSelection.forEach(row=>{
                    ids.push(row.id)
                });
                batchDelete({ids:ids}).then(response => {
                    httpSuccess(response);
                    this.handleFilter();
                }).catch(error => {
                    console.log(error);
                });
            },

            toggleSelection(check)
            {
                if (check) {
                    this.list.forEach(row => {
                        this.$refs.table.toggleRowSelection(row);
                    });
                } else {
                    this.$refs.table.clearSelection();
                }
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            handleChange(data){
                this.form = data;
                this.update();
            },
        },
    };
</script>

<style lang="scss" scoped>

</style>
