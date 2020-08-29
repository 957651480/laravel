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
              <el-date-picker v-model="dateOfProduction" type="date" format="yyyy-MM-dd" placeholder="选择出厂日期" />
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
        <el-row>
          <el-col :span="8">
            <el-form-item label-width="120px" label="品牌:" class="postInfo-container-item">

            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="型号:" class="postInfo-container-item">
              <el-input v-model="form.model" ></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">

          </el-col>
        </el-row>
        <!--<el-form-item style="margin-bottom: 40px;" label-width="70px" label="Summary:">
          <el-input v-model="form.content_short" :rows="1" type="textarea" class="article-textarea" autosize placeholder="Please enter the content" />
          <span v-show="contentShortLength" class="word-counter">{{ contentShortLength }}words</span>
        </el-form-item>

        <el-form-item prop="content" style="margin-bottom: 30px;">
          <Tinymce ref="editor" v-model="form.content" :height="400" />
        </el-form-item>-->
      </div>
    </el-form>
  </div>
</template>

<script>
  import Tinymce from '@/components/Tinymce'
  import Sticky from '@/components/Sticky' // 粘性header组件
  import {createExcavator, fetchExcavator, updateExcavator} from '@/api/excavator'
  import {fetchList} from "@/api/brand";
  import MultipleImage from "@/components/Upload/MultipleImage";
  import SingleVideo from "@/components/Upload/SingleVideo";
  import {httpSuccess} from "@/utils/message";
  import {getUnix} from "@/utils";

  const defaultForm = {
  brand_id:undefined,
  model:'',
  method: '',
  date_of_production: '',
  duration_of_use: undefined,
  equipment_operation: '',
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
}

export default {
  name: 'ArticleDetail',
  components: {MultipleImage, SingleVideo, Tinymce, Sticky },
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
      brands:[]
    }
  },
  computed: {

    dateOfProduction: {
      // back end return => "2013-06-25 06:59:25"
      // front end need timestamp => 1372114765000
      get() {
        return (+new Date(this.form.date_of_production))
      },
      set(val) {
        this.form.date_of_production = getUnix(val);
      }
    }
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    }
    this.tempRoute = Object.assign({}, this.$route);
    this.getRemoteBrandList();
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
      this.$refs.form.validate(valid => {
        if (!valid) return false;
        this.loading = true
        if(this.isEdit){
            updateExcavator(this.form.id,this.form).then(response =>
            {
              httpSuccess(response);
              this.initForm();
            })
            .finally(() => {
              this.loading = false;
            })
        }else {
            createExcavator(this.form).then(response =>
            {
              httpSuccess(response);
              this.initForm();
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
