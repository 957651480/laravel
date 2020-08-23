<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="postForm" :rules="rules" class="form-container" label-width="120px">

      <sticky :z-index="10" :class-name="'sub-navbar '+postForm.status">
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
              <el-select v-model="postForm.brand_id" :remote-method="getRemoteBrandList" filterable default-first-option remote placeholder="选择品牌">
                <el-option v-for="(item,index) in brands" :key="item.id" :label="item.name" :value="item.id" />
              </el-select>
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="型号:" class="postInfo-container-item">
              <el-input v-model="postForm.model" style="width: 217px"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="挖机制式:" class="postInfo-container-item">
              <el-radio v-model="postForm.method" label="1">履带式</el-radio>
              <el-radio v-model="postForm.method" label="2">轮式</el-radio>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="8">
            <el-form-item label-width="120px" label="出厂日期:" class="postInfo-container-item">
              <el-date-picker v-model="displayTime" type="date" format="yyyy-MM-dd" placeholder="选择出厂日期" />
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="使用时长:" class="postInfo-container-item">
              <el-input-number ></el-input-number><span>使用时长,单位(小时)</span>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="设备手术:" class="postInfo-container-item">
              <el-input ></el-input>
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
              <el-select v-model="postForm.author" :remote-method="getRemoteUserList" filterable default-first-option remote placeholder="Search user">
                <el-option v-for="(item,index) in userListOptions" :key="item+index" :label="item" :value="item" />
              </el-select>
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="型号:" class="postInfo-container-item">
              <el-input v-model="postForm.model" style="width: 217px"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="功率:" class="postInfo-container-item">
              <el-input></el-input>
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
              <el-select v-model="postForm.author" :remote-method="getRemoteUserList" filterable default-first-option remote placeholder="Search user">
                <el-option v-for="(item,index) in userListOptions" :key="item+index" :label="item" :value="item" />
              </el-select>
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="型号:" class="postInfo-container-item">
              <el-input v-model="postForm.model" style="width: 217px"></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="流量:" class="postInfo-container-item">
              <el-input-number ></el-input-number>
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
            <el-form-item label-width="120px" label="图片:" class="postInfo-container-item">
              <multiple-image v-model="postForm.image_ids" :file-list.sync="postForm.image_urls" list-type="picture-card"></multiple-image>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label-width="120px" label="视频:" class="postInfo-container-item">
              <single-video v-model="postForm.video" :file_url.sync="postForm.video" :size="2">
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
              <el-select v-model="postForm.author" :remote-method="getRemoteUserList" filterable default-first-option remote placeholder="Search user">
                <el-option v-for="(item,index) in userListOptions" :key="item+index" :label="item" :value="item" />
              </el-select>
            </el-form-item>
          </el-col>

          <el-col :span="10">
            <el-form-item label-width="120px" label="型号:" class="postInfo-container-item">
              <el-input v-model="postForm.model" ></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="6">
            <el-form-item label-width="90px" label="挖机制式:" class="postInfo-container-item">
              <el-date-picker v-model="displayTime" type="datetime" format="yyyy-MM-dd HH:mm:ss" placeholder="Select date and time" />
            </el-form-item>
          </el-col>
        </el-row>
        <!--<el-form-item style="margin-bottom: 40px;" label-width="70px" label="Summary:">
          <el-input v-model="postForm.content_short" :rows="1" type="textarea" class="article-textarea" autosize placeholder="Please enter the content" />
          <span v-show="contentShortLength" class="word-counter">{{ contentShortLength }}words</span>
        </el-form-item>

        <el-form-item prop="content" style="margin-bottom: 30px;">
          <Tinymce ref="editor" v-model="postForm.content" :height="400" />
        </el-form-item>-->
      </div>
    </el-form>
  </div>
</template>

<script>
  import Tinymce from '@/components/Tinymce'
  import Sticky from '@/components/Sticky' // 粘性header组件
  import {fetchArticle} from '@/api/article'
  import {searchUser} from '@/api/remote-search'
  import {fetchList} from "@/api/brand";
  import MultipleImage from "@/components/Upload/MultipleImage";
  import SingleVideo from "@/components/Upload/SingleVideo";

  const defaultForm = {
  brand_id:null,
  model:'',
  status: 'draft',
  title: '', // 文章题目
  content: '', // 文章内容
  content_short: '', // 文章摘要
  source_uri: '', // 文章外链
  image_uri: '', // 文章图片
  display_time: undefined, // 前台展示时间
  id: undefined,
  platforms: ['a-platform'],
  comment_disabled: false,
  importance: 0
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
      postForm: Object.assign({}, defaultForm),
      loading: false,
      userListOptions: [],
      rules: {
        brand_id: [{ required:true,message:'请选择品牌',trigger: 'blur'}],
        title: [{ required:true,trigger: 'blur' }],
        content: [{ required:true,trigger: 'blur' }],
      },
      tempRoute: {},
      brands:[]
    }
  },
  computed: {
    contentShortLength() {
      return this.postForm.content_short.length
    },
    displayTime: {
      // set and get is useful when the data
      // returned by the back end api is different from the front end
      // back end return => "2013-06-25 06:59:25"
      // front end need timestamp => 1372114765000
      get() {
        return (+new Date(this.postForm.display_time))
      },
      set(val) {
        this.postForm.display_time = new Date(val)
      }
    }
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    }

    // Why need to make a copy of this.$route here?
    // Because if you enter this page and quickly switch tag, may be in the execution of the setTagsViewTitle function, this.$route is no longer pointing to the current page
    // https://github.com/PanJiaChen/vue-element-admin/issues/1221
    this.tempRoute = Object.assign({}, this.$route);
    this.getRemoteBrandList();
  },
  methods: {
    fetchData(id) {
      fetchArticle(id).then(response => {
        this.postForm = response.data

        // just for test
        this.postForm.title += `   Article Id:${this.postForm.id}`
        this.postForm.content_short += `   Article Id:${this.postForm.id}`

        // set tagsview title
        this.setTagsViewTitle()

        // set page title
        this.setPageTitle()
      }).catch(err => {
        console.log(err)
      })
    },
    setTagsViewTitle() {
      const title = 'Edit Article'
      const route = Object.assign({}, this.tempRoute, { title: `${title}-${this.postForm.id}` })
      this.$store.dispatch('tagsView/updateVisitedView', route)
    },
    setPageTitle() {
      const title = 'Edit Article'
      document.title = `${title} - ${this.postForm.id}`
    },
    submitForm() {
      console.log(this.postForm)
      this.$refs.postForm.validate(valid => {
        if (valid) {
          this.loading = true
          this.$notify({
            title: '成功',
            message: '发布文章成功',
            type: 'success',
            duration: 2000
          })
          this.postForm.status = 'published'
          this.loading = false
        } else {
          console.log('error submit!!')
          return false
        }
      })
    },
    draftForm() {
      if (this.postForm.content.length === 0 || this.postForm.title.length === 0) {
        this.$message({
          message: '请填写必要的标题和内容',
          type: 'warning'
        })
        return
      }
      this.$message({
        message: '保存成功',
        type: 'success',
        showClose: true,
        duration: 1000
      })
      this.postForm.status = 'draft'
    },
    async getRemoteBrandList(query) {
      let {data} = await fetchList();
      this.brands = data;
    },
    getRemoteUserList(query) {
      searchUser(query).then(response => {
        if (!response.data.items) return
        this.userListOptions = response.data.items.map(v => v.name)
      })
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
