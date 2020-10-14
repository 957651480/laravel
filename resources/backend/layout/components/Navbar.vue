<template>
  <div class="navbar">
    <hamburger id="hamburger-container" :is-active="sidebar.opened" class="hamburger-container" @toggleClick="toggleSideBar" />

    <breadcrumb id="breadcrumb-container" class="breadcrumb-container" />

    <div class="right-menu">
      <template v-if="device!=='mobile'">
        <search id="header-search" class="right-menu-item" />

        <error-log class="errLog-container right-menu-item hover-effect" />

        <screenfull id="screenfull" class="right-menu-item hover-effect" />

        <el-tooltip content="Global Size" effect="dark" placement="bottom">
          <size-select id="size-select" class="right-menu-item hover-effect" />
        </el-tooltip>

      </template>

      <el-dropdown class="avatar-container right-menu-item hover-effect" trigger="click">
        <div class="avatar-wrapper">
          <img v-if="avatar"  :src="avatar+'?imageView2/1/w/80/h/80'" class="user-avatar">
          <img v-else :src="defaultAvatar+'?imageView2/1/w/80/h/80'" class="user-avatar">
          <i class="el-icon-caret-bottom" />
        </div>
        <el-dropdown-menu slot="dropdown">
          <!--<router-link to="/profile/index">
            <el-dropdown-item>Profile</el-dropdown-item>
          </router-link>-->
          <router-link to="/">
            <el-dropdown-item>仪表板</el-dropdown-item>
          </router-link>
          <el-dropdown-item >
            <span style="display:block;" @click="handlePassword">修改密码</span>
          </el-dropdown-item>
          <el-dropdown-item divided @click.native="logout">
            <span style="display:block;">退出</span>
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
    <el-dialog title="修改密码" :visible.sync="passwordDialog" @close='closeDialog'>
      <el-form ref="elForm" :rules="rules" :model="psdForm" label-position="left" label-width="150px" style="max-width: 500px;">
        <el-form-item label="密码:" prop="password">
          <el-input v-model="psdForm.password" placeholder="请输入新密码"></el-input>
        </el-form-item>

      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="submit()">
          保存
        </el-button>
        <el-button @click="closeDialog()">
          取消
        </el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  import Breadcrumb from '@/components/Breadcrumb'
  import Hamburger from '@/components/Hamburger'
  import ErrorLog from '@/components/ErrorLog'
  import Screenfull from '@/components/Screenfull'
  import SizeSelect from '@/components/SizeSelect'
  import Search from '@/components/HeaderSearch'
  import defaultAvatar from '@/assets/default-avatar.gif'

  export default {
  components: {
    Breadcrumb,
    Hamburger,
    ErrorLog,
    Screenfull,
    SizeSelect,
    Search
  },
  data(){
    return {
      defaultAvatar:defaultAvatar,
      passwordDialog:false,
      psdForm:{
        password:'',
      },
      rules:{
        password:[
          {required: true, message: '请输入新的密码', trigger: 'blur'}
        ]
      },
    };
  },
  computed: {
    ...mapGetters([
      'sidebar',
      'avatar',
      'device'
    ])
  },
  methods: {
    toggleSideBar() {
      this.$store.dispatch('app/toggleSideBar')
    },
    handlePassword(){
      this.passwordDialog=true
    },
    closeDialog(){
      this.passwordDialog=false;
      this.$refs['elForm'].resetFields()
    },
    submit() {
      this.$refs['elForm'].validate((valid) => {
        if (valid) {
           this.$store.dispatch('user/modifyPassword',this.psdForm).then(response=>{
            this.$message({
              message: '密码修改成功',
              type: 'success',
            })
            this.passwordDialog=false;
          })
        } else {
          return false;
        }
      });
    },
    async logout() {
      await this.$store.dispatch('user/logout')
      this.$router.push(`/login?redirect=${this.$route.fullPath}`)
    }
  }
}
</script>

<style lang="scss" scoped>
.navbar {
  height: 50px;
  overflow: hidden;
  position: relative;
  background: #fff;
  box-shadow: 0 1px 4px rgba(0,21,41,.08);

  .hamburger-container {
    line-height: 46px;
    height: 100%;
    float: left;
    cursor: pointer;
    transition: background .3s;
    -webkit-tap-highlight-color:transparent;

    &:hover {
      background: rgba(0, 0, 0, .025)
    }
  }

  .breadcrumb-container {
    float: left;
  }

  .errLog-container {
    display: inline-block;
    vertical-align: top;
  }

  .right-menu {
    float: right;
    height: 100%;
    line-height: 50px;

    &:focus {
      outline: none;
    }

    .right-menu-item {
      display: inline-block;
      padding: 0 8px;
      height: 100%;
      font-size: 18px;
      color: #5a5e66;
      vertical-align: text-bottom;

      &.hover-effect {
        cursor: pointer;
        transition: background .3s;

        &:hover {
          background: rgba(0, 0, 0, .025)
        }
      }
    }

    .avatar-container {
      margin-right: 30px;

      .avatar-wrapper {
        margin-top: 5px;
        position: relative;

        .user-avatar {
          cursor: pointer;
          width: 40px;
          height: 40px;
          border-radius: 10px;
        }

        .el-icon-caret-bottom {
          cursor: pointer;
          position: absolute;
          right: -20px;
          top: 25px;
          font-size: 12px;
        }
      }
    }
  }
}
</style>
