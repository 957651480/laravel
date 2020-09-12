<template>
  <div class="createPost-container">
    <el-form ref="form" :model="form" :rules="rules" class="form-container" label-width="120px">

      <sticky :z-index="10" :class-name="'sub-navbar '+form.status">
        <el-button v-loading="loading" style="margin-left: 10px;" type="success" @click="submitForm">
          发布
        </el-button>
        <el-button v-loading="loading" type="warning" @click="draftForm">
          取消
        </el-button>
      </sticky>

      <div class="createPost-main-container">
        <div  data-backend-compiled="">
          <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default am-no-layout">
            <h2 class="am-titlebar-title">基本信息</h2>
          </div>
        </div>
        <el-divider></el-divider>
        <el-row>
          <el-col :span="8">
            <el-form-item label-width="120px" label="品牌:" class="postInfo-container-item" prop="brand_id">
              <el-select v-model="form.brand_id" :remote-method="getRemoteBrandList" filterable default-first-option remote placeholder="选择品牌">
                <el-option v-for="(item,index) in brands" :key="item.id" :label="item.name" :value="item.id" />
              </el-select>
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="型号:" class="postInfo-container-item" prop="model">
              <el-input v-model="form.model" style="width: 217px"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="挖机制式:" class="postInfo-container-item">
              <el-input v-model="form.method" ></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="8">
            <el-form-item label-width="120px" label="出厂日期:" class="postInfo-container-item" prop="date_of_production">
              <el-date-picker v-model="form.date_of_production" type="date" value-format="yyyy-MM-dd" placeholder="选择出厂日期" />
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="使用时长:" class="postInfo-container-item">
              <el-input-number v-model="form.duration_of_use"></el-input-number><span>使用时长,单位(小时)</span>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="设备手术:" class="postInfo-container-item">
              <el-input v-model="form.equipment_operation"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item   label="地址" prop="region_id">
              <el-cascader
                      v-model="form.region_id"
                      :props="optionProps"
                      :options="regionTrees"
              ></el-cascader>
            </el-form-item>
          </el-col>
        </el-row>
        <div  >
          <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default am-no-layout">
            <h2 class="am-titlebar-title">发动机信息</h2>
          </div>
        </div>
        <el-divider></el-divider>
        <el-row>
          <el-col :span="8">
            <el-form-item label-width="120px" label="品牌:" class="postInfo-container-item">
              <el-input v-model="form.motor_brand" style="width: 217px"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="型号:" class="postInfo-container-item">
              <el-input v-model="form.motor_model" style="width: 217px"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="功率:" class="postInfo-container-item">
              <el-input-number v-model="form.motor_rate_of_work"></el-input-number>
            </el-form-item>
          </el-col>
        </el-row>
        <div  >
          <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default am-no-layout">
            <h2 class="am-titlebar-title">液压泵信息</h2>
          </div>
        </div>
        <el-divider></el-divider>
        <el-row>
          <el-col :span="8">
            <el-form-item label-width="120px" label="品牌:" class="postInfo-container-item">
              <el-input v-model="form.hydraulic_pump_rand" style="width: 217px"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="型号:" class="postInfo-container-item">
              <el-input v-model="form.hydraulic_pump_model" style="width: 217px"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="流量:" class="postInfo-container-item">
              <el-input-number v-model="form.hydraulic_pump_flow"></el-input-number>
            </el-form-item>
          </el-col>
        </el-row>
        <div  >
          <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default am-no-layout">
            <h2 class="am-titlebar-title">产品图片</h2>
          </div>
        </div>
        <el-divider></el-divider>
        <el-row>
          <el-col :span="14">
            <el-form-item label-width="120px" label="图片:" class="postInfo-container-item" prop="image_ids">
              <multiple-image v-model="form.image_ids" :file-list="form.image_urls" ></multiple-image>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label-width="120px" label="视频:" class="postInfo-container-item">
              <single-video v-model="form.video_id" :file_url="form.video_url" :size="2">
              </single-video>
            </el-form-item>
          </el-col>
        </el-row>
        <div  >
          <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default am-no-layout">
            <h2 class="am-titlebar-title">费用明细</h2>
          </div>
        </div>
        <el-divider></el-divider>
        <el-row v-for="(cost,index) in form.costs" :key="index">

            <el-form-item :prop="'costs.' + index + '.name'" label="明细组名称:"
                          :rules="{required: true, message: '明细组不能为空', trigger: 'blur'}">
              <el-col :span="8">
                <el-input v-model="cost.name" ></el-input>
              </el-col>
              <el-col :span="4" v-if="(index+1)==form.costs.length" style="margin-left: 20px;">
                <el-button type="primary" class="el-icon-plus" @click.prevent="addGroup(form.costs)">添加</el-button>
                <el-button type="danger" class="el-icon-delete" @click.prevent="removeGroup(form.costs,index)">删除</el-button>
              </el-col>
            </el-form-item>

          <el-form-item label-width="0" v-for="(item,key) in cost.children" :key="key" style="margin-left: 50px;">
            <el-col :span="8">
              <el-form-item :prop="'costs.' + index + '.children.'+key+'.name'" label="子项名称:"
                            :rules="{required: true, message: '名称不能为空', trigger: 'blur'}">
                <el-input v-model="item.name"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="2"></el-col>
            <el-col :span="8">
              <el-form-item :prop="'costs.' + index + '.children.'+key+'.rmb'" label="子项价格:"
                            :rules="{required: true, message: '价格不能为空', trigger: 'blur'}">
                <el-input v-model="item.rmb">
                  <template slot="append">RMB</template>
                </el-input>
              </el-form-item>
            </el-col>
            <el-col :span="4" v-if="(key+1)==cost.children.length" style="margin-left: 20px;">
              <el-button type="primary" class="el-icon-plus" @click.prevent="addItem(cost.children)">添加</el-button>
              <el-button type="danger" class="el-icon-delete" @click.prevent="removeItem(cost.children,key)">删除</el-button>
            </el-col>
          </el-form-item>
        </el-row>

      </div>
    </el-form>
  </div>
</template>

<script>
  import Sticky from '@/components/Sticky' // 粘性header组件
  import {createExcavator, fetchCost, fetchExcavator, updateExcavator} from '@/api/excavator'
  import {fetchTree} from '@/api/region'
  import {fetchList} from "@/api/brand";
  import MultipleImage from "@/components/Upload/MultipleImage";
  import SingleVideo from "@/components/Upload/SingleVideo";
  import {httpSuccess} from "@/utils/message";

  const defaultForm = {
  brand_id:undefined,
  model:'',
  method: '',
  date_of_production: undefined,
  duration_of_use: undefined,
  equipment_operation: '',
  region_id:undefined,
  motor_brand: '',
  motor_model: '',
  motor_rate_of_work: undefined,
  hydraulic_pump_rand: undefined,
  hydraulic_pump_model: undefined,
  hydraulic_pump_flow: undefined,
  image_ids:[],
  image_urls:[],
  video_id:undefined,
  video_url:undefined,
  costs:[],
}

export default {
  name: 'ExcavatorDetail',
  components: {MultipleImage, SingleVideo, Sticky },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {

    return {
      form: Object.assign({}, defaultForm),
      loading: false,
      userListOptions: [],
      rules: {
        brand_id: [{ required:true,message:'请选择品牌',trigger: 'blur'}],
        model: [{ required:true,message:'请填写模型',trigger: 'blur' }],
        date_of_production: [{ required:true,message:'请选择出厂日期',trigger: 'blur' }],
        image_ids: [{ required:true,message:'请上传图片',trigger: 'blur' }],
      },
      tempRoute: {},
      brands:[],
      optionProps:{
        value: 'id',
        label: 'name',
        emitPath:false
      },
      regionTrees:[],
    }
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    }else {
      this.getCostList();
    }
    this.tempRoute = Object.assign({}, this.$route);
    this.getRemoteBrandList();
    this.getRegionList();
  },
  methods: {
    fetchData(id) {
      fetchExcavator(id).then(response => {
        this.form = response.data
        this.setTagsViewTitle()
        this.setPageTitle()
      })
    },
    setTagsViewTitle() {
      const title = '编辑挖机'
      const route = Object.assign({}, this.tempRoute, { title: `${title}-${this.form.id}` })
      this.$store.dispatch('tagsView/updateVisitedView', route)
    },
    setPageTitle() {
      const title = '编辑挖机'
      document.title = `${title} - ${this.form.id}`
    },
    submitForm() {
      const that = this;
      this.$refs.form.validate(valid => {
        if (!valid) return false;
        this.loading = true
        if(this.isEdit){
            updateExcavator(this.form.id,this.form).then(response =>
            {
              httpSuccess(response);
              that.$router.push({
                path: '/excavator/list',
              });
            })
            .finally(() => {
              this.loading = false;
            })
        }else {
            createExcavator(this.form).then(response =>
            {
              httpSuccess(response);
              that.$router.push({
                path: '/excavator/list',
              });
            })
            .finally(() => {
              this.loading = false;
            })
        }
      })
    },
    initForm() {
      if (this.$refs.form) {
        this.$refs.form.resetFields();
      }
      this.form = defaultForm;
    },
    draftForm() {

    },
    async getRemoteBrandList(query) {
      let {data} = await fetchList();
      this.brands = data;
    },
    async getCostList(query) {
      let {data} = await fetchCost();
      this.form.costs = data;
    },
    async getRegionList() {
      const { data } = await fetchTree({need_level:2});
      this.regionTrees = this.getTreeData(data);
    },
    // 递归判断列表，把最后的children设为undefined
    getTreeData(data){
      for(let i=0;i<data.length;i++){
        if(data[i].children.length<1){
          // children若为空数组，则将children设为undefined
          data[i].children=undefined;
        }else {
          // children若不为空数组，则继续 递归调用 本方法
          this.getTreeData(data[i].children);
        }
      }
      return data;
    },
    removeItem(item,index){

      if(index===0){
        this.$message({
          message: '不能删除子项第一项',
          type: 'warning'
        });
      }else {
        item.splice(index, 1)
      }
    },
    addItem(item){
      item.push({name:'',rmb:'',jpn:''});
    },
    removeGroup(item,index){
      if(index===0){
        this.$message({
          message: '不能删除分组第一项',
          type: 'warning'
        });
      }else {
        item.splice(index, 1)
      }
    },
    addGroup(item){
      item.push({name:'',children:[
          {name:'',rmb:'',jpn:''}
        ]});
    }
  }
}
</script>

<style lang="scss" scoped>
@import "~@/styles/mixin.scss";

.createPost-container {
  position: relative;

  .createPost-main-container {
    padding: 40px 45px 20px 50px;

    .postInfo-container {
      position: relative;
      @include clearfix;
      margin-bottom: 10px;

      .postInfo-container-item {
        float: left;
      }
    }
  }

  .word-counter {
    width: 40px;
    position: absolute;
    right: 10px;
    top: 0px;
  }
}

.article-textarea ::v-deep {
  textarea {
    padding-right: 40px;
    resize: none;
    border: none;
    border-radius: 0px;
    border-bottom: 1px solid #bfcbd9;
  }
}
.am-titlebar-default a {
  color: #0e90d2
}

.am-titlebar-default .am-titlebar-title {
  position: relative;
  padding-left: 12px;
  color: #0e90d2;
  font-size: 1.8rem;
  text-align: left;
  font-weight: 700
}

.am-titlebar-default .am-titlebar-title:before {
  content: "";
  position: absolute;
  left: 2px;
  top: 8px;
  bottom: 8px;
  border-left: 3px solid #0e90d2
}
</style>
