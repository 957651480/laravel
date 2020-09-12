<template>
  <div class="app-container">
    <el-form :inline="true" >
      <el-form-item label="轮播标题:">
        <el-input v-model="query.brand_id" placeholder="请输入轮播标题" clearable style="width: 200px;" @change="handleFilter" class="filter-item" @keyup.enter.native="handleFilter" />
      </el-form-item>
      <el-button v-waves type="primary" icon="el-icon-search" @click="handleFilter">
        搜索
      </el-button>
    </el-form>

    <el-table v-loading="tableLoading" :data="list" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column width="180px" align="center" label="型号">
        <template slot-scope="scope">
          <span>{{ scope.row.model}}</span>
        </template>
      </el-table-column>

      <el-table-column width="120px" align="center" label="品牌">
        <template slot-scope="scope">
          <span>{{ scope.row.brand_name }}</span>
        </template>
      </el-table-column>
      <el-table-column  label="图片" width="110">
        <template slot-scope="scope">
          <el-image
                  style="width: 80px; height: 80px"
                  :src="scope.row.image_urls[0].url"
                  :preview-src-list="showImageList(scope.row.image_urls)"
          ></el-image>
        </template>
      </el-table-column>
      <el-table-column width="100px" label="挖机制式">
        <template slot-scope="scope">
          <span>{{ scope.row.method }}</span>
        </template>
      </el-table-column>

      <el-table-column  label="出厂日期" width="110">
        <template slot-scope="{row}">
            {{ row.date_of_production }}
        </template>
      </el-table-column>
      <el-table-column  label="使用时长" width="110">
        <template slot-scope="{row}">
          {{ row.duration_of_use }}(小时)
        </template>
      </el-table-column>
      <el-table-column  label="设备手术" width="110">
        <template slot-scope="{row}">
          {{ row.equipment_operation }}
        </template>
      </el-table-column>
      <!--<el-table-column class-name="status-col" label="Status" width="110">
        <template slot-scope="{row}">
          <el-tag :type="row.status | statusFilter">
            {{ row.status }}
          </el-tag>
        </template>
      </el-table-column>-->

      <!--<el-table-column min-width="300px" label="Title">
        <template slot-scope="{row}">
          <router-link :to="'/example/edit/'+row.id" class="link-type">
            <span>{{ row.title }}</span>
          </router-link>
        </template>
      </el-table-column>-->

      <el-table-column align="center" label="操作" width="350">
        <template slot-scope="scope">
          <router-link :to="'/excavator/edit/'+scope.row.id">
            <el-button type="primary" size="small" icon="el-icon-edit">
              编辑
            </el-button>
          </router-link>
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.$index,scope.row)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getList" />
  </div>
</template>

<script>
  import {deleteExcavator, fetchList} from '@/api/excavator'
  import {fetchList as fetchBrandList} from '@/api/brand'
  import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
  import waves from '@/directive/waves';
  import {confirmMessage, httpSuccess} from "@/utils/message";


  export default {
  name: 'ArticleList',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      list: null,
      total: 0,
      tableLoading: true,
      query: {
        page: 1,
        limit: 20
      },
      brands:[]
    }
  },
  created() {
    this.getList();
    this.getRemoteBrandList();
  },
  methods: {
    async getList() {
      this.tableLoading = true;
      const { total,data } = await fetchList(this.query);
      this.list = data;
      this.total = total;
      this.tableLoading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    async getRemoteBrandList(query) {
      let {data} = await fetchBrandList();
      this.brands = data;
    },
    handleDelete(index,row) {
      confirmMessage('确定删除吗?').then(() => {
        deleteExcavator(row.id).then(response => {
          httpSuccess(response);
          this.handleFilter();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
      });
    },
    showImageList(imageList){
      let tmpList = [];
      for (let i = 0;i < imageList.length;i++){
        tmpList[i]=imageList[i].url;
      }
      return tmpList;
    },
  }
}
</script>

<style scoped>
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
</style>
