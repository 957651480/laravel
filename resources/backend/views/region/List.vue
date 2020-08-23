<template>
  <div class="app-container">
    <el-form :inline="true" >
      <el-form-item label="地区名称:">
        <el-input v-model="query.title" placeholder="请输入地区名称搜索" clearable style="width: 200px;" @change="handleFilter" class="filter-item" @keyup.enter.native="handleFilter" />
      </el-form-item>
      <el-button v-waves type="primary" icon="el-icon-search" @click="handleFilter">
        搜索
      </el-button>
      <el-button type="primary" icon="el-icon-plus" @click="handleCreate">
        添加顶级地区
      </el-button>

    </el-form>

    <el-table
            ref="table" v-loading="tableLoading" :data="list"
            :tree-props="{children: 'children', hasChildren: 'has_children'}"
            border
            fit
            lazy
            :load="load"
            row-key="id"
            style="width: 100%">

      <el-table-column  label="地区" prop="name" ></el-table-column>

      <el-table-column align="center" label="简称">
        <template slot-scope="scope">
          <span>{{ scope.row.short_name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="合并名称">
        <template slot-scope="scope">
          <span>{{ scope.row.merger_name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="层级">
        <template slot-scope="scope">
          <span>{{ scope.row.level }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="拼音码">
        <template slot-scope="scope">
          <span>{{ scope.row.pinyin }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="长途区号">
        <template slot-scope="scope">
          <span>{{ scope.row.code }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="邮编">
        <template slot-scope="scope">
          <span>{{ scope.row.zip_code }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="首字母">
        <template slot-scope="scope">
          <span>{{ scope.row.first }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="操作" width="350" fixed="right">
        <template slot-scope="scope">
          <el-button type="primary" size="small" icon="el-icon-plus" @click="handleCreateNode(scope.$index,scope.row)">
            添加子地区
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

    <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getTopList" />
    <el-dialog :title="dialog.title" :visible.sync="dialog.visible" @close='closeDialog'>
      <div v-loading="formCreating" class="form-container">
        <el-form ref="form" :rules="rules" :model="form" label-position="left" label-width="100px">
          <el-form-item label="地区名:" prop="name">
            <el-input v-model="form.name" show-word-limit maxlength="25"/>
          </el-form-item>
          <el-form-item label="上级地区:" prop="parent_id" >
            <el-cascader v-model="form.parent_id"
                         :options="normalizedParentOption"
                         :props="parentIdProps"

            ></el-cascader>
          </el-form-item>
          <el-form-item label="拼音码:" prop="pinyin">
            <el-input v-model="form.pinyin" />
          </el-form-item>
          <el-form-item label="短名称:" prop="short_name">
            <el-input v-model="form.short_name" />
          </el-form-item>
          <el-form-item label="全称:" prop="merger_name">
            <el-input v-model="form.merger_name" />
          </el-form-item>
          <el-form-item label="长途区号:">
            <el-input v-model="form.code" />
          </el-form-item>
          <el-form-item label="邮编:" >
            <el-input v-model="form.zip_code" />
          </el-form-item>
          <el-form-item label="首字母:" >
            <el-input v-model="form.first" />
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
  import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
  import waves from '@/directive/waves'; // Waves directive
  import {batchDelete, createRegion, deleteRegion, fetchTopList, fetchTree, updateRegion} from '@/api/region';
  import {confirmMessage, httpSuccess} from "@/utils/message";
  import CustomElementSwitch from "@/components/Element/Switch/CustomElementSwitch";
  import {deepClone, emptyArrayToUndefinedRecursive, fetchTreeChildren} from "@/utils";
  import defaultDialog from "@/utils/dialog";

  const defaultForm ={
    id:null,
    name: '',
    parent_id:null,
    level:1,
    pinyin:'',
    show:10,
    sort: 100,
  }
  export default {
    name: 'RegionList',
    components: {CustomElementSwitch,Pagination },
    directives: { waves },
    data() {
      return {
        list: [],
        tree: [],
        total: 0,
        tableLoading: false,
        downloading: false,
        formCreating: false,
        tabActiveIndex:'first',
        isAllSelect:false,
        query: {
          page: 1,
          limit: 10,
          name: '',
        },
        form: defaultForm,
        dialog:defaultDialog,
        rules: {
          name: [{ required: true, message: '地区名必须', trigger: 'blur' }],
          parent_id: [{ required: true, message: '上级地区名必须', trigger: 'blur' }],
        },
        parentRootOptions: {
          id:100000,
          parent_id:100000,
          name: "顶级栏目"
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
      this.getTopList();
      this.getTree();
    },
    computed:{
      normalizedParentOption(){
        let parentOptions=deepClone(this.tree);
        parentOptions = emptyArrayToUndefinedRecursive(parentOptions,'children')
        parentOptions.unshift(this.parentRootOptions);
        return parentOptions;
      },
    },

    methods: {
      async getTopList() {
        this.tableLoading = true;
        const {total,data} = await fetchTopList(this.query);
        this.list = data;
        this.total=total;
        this.tableLoading = false;
      },
      async getTree() {
        const {data} = await fetchTree({parent_id: 0});
        this.tree = data;
      },
      handleFilter() {
        this.getTopList();
      },
      handleCreate()
      {
        this.initForm();
        this.form.parent_id = 100000;
        this.setDialog({title: '新增', type: 'add', visible: true});
      },
      handleEdit(index,row) {

        this.form = row;
        if(row.parent_id===0){
          this.form.parent_id=100000;
        }
        this.setDialog({title: '编辑', type: 'edit', visible: true});
      },
      handleCreateNode(index,row) {
        this.initForm();
        this.form.parent_id =row.id;
        this.form.level =row.level+1;
        this.setDialog({title: '新增子地区', type: 'node', visible: true});
      },

      handleDelete(index,id) {
        confirmMessage('确定删除吗?').then(() => {
          deleteRegion(id).then(response => {
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
        this.tabActiveIndex='first';
      },
      enterDialog() {
        this.$refs['form'].validate((valid) =>
        {
          if (!valid) return false;
          this.formCreating = true;
          switch (this.dialog.type) {
            case 'add':
            case 'node':
              createRegion(this.form).then(response =>
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
              updateRegion(id,this.form)
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
        });
      },
      handleChange(index,data) {
        updateRegion(data.id,data).then(response => {
          httpSuccess(response);
        });
      },

      setDialog(options)
      {
        this.dialog=options?options:defaultDialog;
      },

      load(tree, treeNode, resolve){
        setTimeout(() => {
          resolve(fetchTreeChildren(this.tree,tree.id))
        }, 1000)
      }
    }
  };
</script>

<style lang="scss" scoped>

</style>
