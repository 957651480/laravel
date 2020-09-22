<template>
    <div class="app-container">
        <el-form :inline="true" >
            <el-form-item label="用户昵称:">
                <el-input v-model="query.nickname" placeholder="请输入用户昵称" clearable style="width: 200px;" @change="handleFilter" class="filter-item" @keyup.enter.native="handleFilter" />
            </el-form-item>
            <el-button v-waves type="primary" icon="el-icon-search" @click="handleFilter">
                搜索
            </el-button>

        </el-form>

        <base-table :data="list" :columns="columns" ref="table" v-loading="tableLoading"  border fit highlight-current-row style="width: 100%"
                    >
            <el-table-column align="center" label="用户头像" slot="visit_user_avatar" >
                <template slot-scope="scope">
                    <el-image
                            style="width: 80px; height: 80px"
                            :src="scope.row.avatar"
                            :preview-src-list="[scope.row.avatar]"
                    ></el-image>
                </template>
            </el-table-column>

        </base-table>
        <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getList" />
    </div>
</template>

<script>
    import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
    import waves from '@/directive/waves'; // Waves directive
    import BaseTable from "@/components/Element/Table/BaseTable";
    import {fetchWeChatList} from "@/api/user";

    export default {
        name: 'BannerList',
        components: { BaseTable,  Pagination },
        directives: { waves },
        data() {
            return {
                list: null,
                total: 0,
                tableLoading: true,
                query: {
                    page: 1,
                    limit: 15,
                    nickname: '',
                },
                columns:[

                    {
                        prop: "nickname",
                        label: "用户昵称"
                    },
                    {
                        slot: "avatar",
                    },
                    {
                        prop: "openid",
                        label: "微信OPENID"
                    },
                    {
                        prop: "created_at",
                        label: "时间"
                    },
                    {
                        slot:'operate'
                    }
                ],

            };
        },

        created() {
            this.getList();
        },
        methods: {
            async getList() {
                this.tableLoading = true;
                const { total,data } = await fetchWeChatList(this.query);
                this.list = data;
                this.total = total;
                this.tableLoading = false;
            },
            handleFilter() {
                this.query.page = 1;
                this.getList();
            },
            showImageList(imageList){
                let tmpList = [];
                for (let i = 0;i < imageList.length;i++){
                    tmpList[i]=imageList[i].url;
                }
                return tmpList;
            },

        },
    };
</script>

<style lang="scss" scoped>

</style>
