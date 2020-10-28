<template>
  <div class="createPost-container">
    <el-form ref="form" :model="form" :rules="rules" label-position="right" label-width="120px">

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
          <el-col :span="6">
            <el-form-item  label="名称:"  prop="name">
              <el-input v-model="form.name"  placeholder="请输入挖机名称"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item  label="品牌:"  prop="brand_id">
              <el-select v-model="form.brand_id" :remote-method="getRemoteBrandList" filterable default-first-option remote placeholder="选择品牌" style="width: 100%;">
                <el-option v-for="(item,index) in brands" :key="item.id" :label="item.name" :value="item.id" />
              </el-select>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item  label="型号:"  prop="model">
              <el-input v-model="form.model" placeholder="请输入挖机型号"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item  label="价格:"  prop="price">
              <el-input v-model="form.price" onkeyup="this.value = this.value.replace(/[^\d.]/g,'');" placeholder="请输入挖机价格"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item  label="挖机制式:" >
              <el-input v-model="form.method" placeholder="请输入挖机制式,如:轮滑式或者滚轮式"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item label="日期:"  prop="date_of_production">
              <el-date-picker v-model="form.date_of_production" type="date" value-format="yyyy-MM-dd" placeholder="选择出厂日期" style="width: 100%;"/>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item  label="使用时长:" >
              <el-input v-model="form.duration_of_use" onkeyup="this.value = this.value.replace(/[^\d.]/g,'');" placeholder="请输入挖机使用时长">
                <template slot="append">小时</template>
              </el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item  label="设备手术:" >
              <el-input v-model="form.equipment_operation" placeholder="请输入挖机设备手术"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item  label="重量" prop="weight" >
              <el-input v-model="form.weight" onkeyup="this.value = this.value.replace(/[^\d.]/g,'');" placeholder="请输入挖机重量">
                <template slot="append">KG</template>
              </el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item   label="地址" prop="address" >
              <el-input v-model="form.address" placeholder="请填写地址"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item  label="推荐:" class="postInfo-container-item">
              <el-radio v-model="form.recommend" :label="10">是</el-radio>
              <el-radio v-model="form.recommend" :label="20">否</el-radio>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item   label="排序" prop="sort" >
              <el-input v-model="form.sort" onkeyup="this.value = this.value.replace(/[^\d.]/g,'');" placeholder="请输入排序值,值越大越靠前">
              </el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <div >
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
            <h2 class="am-titlebar-title">产品图片</h2>
          </div>
        </div>
        <el-divider></el-divider>
        <el-row>
          <el-col :span="14">
            <el-form-item label-width="120px" label="图片:" class="postInfo-container-item" prop="image_ids">
              <multiple-image v-model="form.image_ids" :file-list="form.image_urls" :limit="10"></multiple-image>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label-width="120px" label="视频:" class="postInfo-container-item">
              <single-video v-model="form.video_id" :file_url="form.video_url" :size="2" :limit="6">
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
        <el-row>
          <el-col :span="6">
            <el-form-item  label="吨位" >
              <el-select  v-model="cost_list_index" @change="handleWeight" placeholder="选择吨位" style="width: 100%;">
                <el-option v-for="(item,index) in cost_list" :key="index" :label="item.name" :value="index" />
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item  label="申报机价:" >
                <el-input v-model="quoted_price"  @input="handleQuoted" onkeyup="this.value = this.value.replace(/[^\d.]/g,'');">
                  <template slot="append">RMB</template>
                </el-input>
            </el-form-item>
          </el-col>
          <el-col :span="4">
            <el-form-item  label="关税" >
              <el-input v-model="tax" @input="handleTax" onkeyup="this.value = this.value.replace(/[^\d.]/g,'');">
                <template slot="append">%</template>
              </el-input>
            </el-form-item>
          </el-col>
          <el-col :span="4">
            <el-form-item  label="增值税" >
              <el-input v-model="increment_tax" @input="handleIncrementTax" onkeyup="this.value = this.value.replace(/[^\d.]/g,'');">
                <template slot="append">%</template>
              </el-input>
            </el-form-item>
          </el-col>
        </el-row>
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
            <el-col :span="6">
              <el-form-item :prop="'costs.' + index + '.children.'+key+'.name'" label="子项名称:"
                            :rules="{required: true, message: '名称不能为空', trigger: 'blur'}">
                <el-input v-model="item.name"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="2"></el-col>
            <el-col :span="6">
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
  name:'',
  brand_id:undefined,
  model:'',
  method: '',
  price: '',
  date_of_production: undefined,
  duration_of_use: undefined,
  equipment_operation: '',
  weight: undefined,
  recommend: undefined,
  sort: undefined,
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
  address:'',
  costs:[],
}

export default {
  name: 'ExcavatorDetail',
  components: { MultipleImage, SingleVideo, Sticky },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {

    return {
      form: JSON.parse(JSON.stringify(defaultForm)),
      loading: false,
      userListOptions: [],
      rules: {
        name: [{ required:true,message:'请填写挖机名称',trigger: 'blur'}],
        price: [{ required:true,message:'请填写挖机价格',trigger: 'blur'}],
        brand_id: [{ required:true,message:'请选择品牌',trigger: 'blur'}],
        model: [{ required:true,message:'请填写型号',trigger: 'blur' }],
        date_of_production: [{ required:true,message:'请选择出厂日期',trigger: 'blur' }],
        address: [{ required:true,message:'请填写地址',trigger: 'blur'}],
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
      cost_list:[],
      cost_list_index:null,
      quoted_price:null,
      tax:8,
      increment_tax:13,
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
  },
  methods: {
    fetchData(id) {
      fetchExcavator(id).then(response => {
        this.form = response.data
        this.setTataxViewTitle()
        this.setPageTitle()
      })
    },
    setTataxViewTitle() {
      const title = '编辑挖机'
      const route = Object.assign({}, this.tempRoute, { title: `${title}-${this.form.id}` })
      this.$store.dispatch('tataxView/updateVisitedView', route)
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
      this.form = JSON.parse(JSON.stringify(defaultForm));
    },
    draftForm() {

    },
    async getRemoteBrandList(query) {
      let {data} = await fetchList();
      this.brands = data;
    },
    async getCostList(query) {
      let {data} = await fetchCost();
      this.cost_list=data;
      this.form.costs = data[0].costs;
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
    },
    handleWeight(index){
      let costs= this.cost_list[index].costs;
      this.form.costs=JSON.parse(JSON.stringify(costs));
    },
    getShuier(){
      let shuier = this.form.costs.find((item)=>{
        return item.sum;
      });
      return shuier;
    },
    handleQuoted(value){
      if(value==''){
        return false;
      }
      let price= parseInt(value);
      debugger
      if(price<=0){
        return false;
      }
      let shuier = this.getShuier();
      if(!shuier){
        return false
      }
      //设置申报价
      let quoted_price_item = shuier.children.find((item)=>{
        return item.key=='quoted_price'
      })
      quoted_price_item.rmb=price;
      //设置关税
      let tax_price=0;
      if(this.tax>0){
        let tax_item = shuier.children.find((item)=>{
          return item.key=='tax';
        })
        tax_item.rmb=price*(this.tax/100).toFixed(2);
        tax_price=tax_item.rmb;
      }
      //设置增值税
      if(this.tax>0&&this.increment_tax>0){
        let increment_tax_item = shuier.children.find((item)=>{
          return item.key=='increment_tax'
        })
        increment_tax_item.rmb=((price+tax_price)*(this.increment_tax/100)).toFixed(2)
      }
    },
    handleTax(value){
      if(value==''){
        return false;
      }
      let tax= parseInt(value);
      if(tax<=0){
        return false;
      }
      let price= parseInt(this.quoted_price);
      if(!this.quoted_price){
        this.$message("请填写申报价");
        return false;
      }
      let shuier = this.getShuier();
      if(!shuier){
        return false
      }
      let tax_item = shuier.children.find((item)=>{
        return item.key=='tax'
      })
      tax_item.rmb=price*(tax/100).toFixed(2);
      tax_item.name=tax_item.name.replace(/[\d]+/,tax);
      let tax_price = tax_item.rmb;
      if(this.increment_tax>0){
        let increment_tax_item = shuier.children.find((item)=>{
          return item.key=='increment_tax'
        })
        increment_tax_item.rmb=((price+tax_price)*(this.increment_tax/100)).toFixed(2)
      }
    },
    handleIncrementTax(value){
      if(value==''){
        return false;
      }
      let increment_tax= parseInt(value);
      if(increment_tax<=0){
        return false;
      }
      let price= parseInt(this.quoted_price);
      let tax= parseInt(this.tax);
      if(!price){
        this.$message("请填写申报价");
        return false;
      }
      if(!tax){
        this.$message("请填写申报价");
        return false;
      }
      let shuier = this.getShuier();
      if(!shuier){
        return false
      }
      let tax_item = shuier.children.find((item)=>{
        return item.key=='tax'
      })

      let increment_tax_item = shuier.children.find((item)=>{
        return item.key=='increment_tax'
      })
      increment_tax_item.rmb=((price+tax_item.rmb)*(increment_tax/100)).toFixed(2)
      increment_tax_item.name=increment_tax_item.name.replace(/[\d]+/,increment_tax);
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
