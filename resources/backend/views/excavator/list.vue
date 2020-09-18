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
      <el-table-column align="center" label="排序" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.sort }}</span>
        </template>
      </el-table-column>
      <el-table-column width="180px" align="center" label="名称">
        <template slot-scope="scope">
          <span>{{ scope.row.name}}</span>
        </template>
      </el-table-column>
      <el-table-column  label="图片" align="center">
        <template slot-scope="scope">
          <el-image
                  style="width: 80px; height: 80px"
                  :src="scope.row.image_urls[0].url"
                  :preview-src-list="showImageList(scope.row.image_urls)"
          ></el-image>
        </template>
      </el-table-column>
      <el-table-column  label="出厂日期" align="center">
        <template slot-scope="{row}">
            {{ row.date_of_production }}
        </template>
      </el-table-column>
      <el-table-column  label="使用时长" align="center">
        <template slot-scope="{row}">
          {{ row.duration_of_use }}(小时)
        </template>
      </el-table-column>
      <el-table-column  label="重量" align="center">
        <template slot-scope="{row}">
          {{ row.weight }}
        </template>
      </el-table-column>
      <el-table-column  label="地址" align="center">
        <template slot-scope="{row}">
          {{ row.region_merger_name }}
        </template>
      </el-table-column>
      <el-table-column  label="推荐" align="center">
        <template slot-scope="{row}">
          {{ row.recommend==10?`是`:`否` }}
        </template>
      </el-table-column>
      <el-table-column align="center" label="操作" width="250">
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
