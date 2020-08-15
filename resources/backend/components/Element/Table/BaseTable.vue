<template>
    <div v-bind="$attrs" class="base-table">
        <slot name="title"/>
        <slot/>
        <el-table
                :data="data"
                :ref="$attrs.ref"
                v-bind="tableAttrs"
                v-on="$listeners"
        >
            <el-table-column v-if="options.select" type="selection" style="width: 55px;">
            </el-table-column>

            <!--region 数据列-->
            <template v-for="(column, index) in columns">

                <!-- slot 添加自定义配置项 -->
                <slot  v-if="column.slot"  :name="column.slot"></slot>

                <!-- 默认渲染列 -->
                <el-table-column v-else :prop="column.prop"
                                 :key='column.label'
                                 :label="column.label"
                                 :align="column.align"
                                 :width="column.width"
                                 :show-overflow-tooltip="true">
                    <template slot-scope="scope">
                        <template v-if="!column.render">
                            <template v-if="column.formatter">
                                <span v-html="column.formatter(scope.row, column)"></span>
                            </template>
                            <template v-else>
                                <span>{{scope.row[column.prop]}}</span>
                            </template>
                        </template>
                        <template v-else>
                            <expand-dom :column="column" :row="scope.row" :render="column.render" :index="index"></expand-dom>
                        </template>
                    </template>
                </el-table-column>

            </template>
            <!--endregion-->
        </el-table>
        <el-pagination
                v-if="paginationAttrs.isPagination"
                v-bind="paginationAttrs"
                class="pagination-container"
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
        />
    </div>
</template>
<script>
    import {
        defaultTableAttrs,
        defaultColumn,
        defaultPagination
    } from './tableConfig'
    export default {
        name: 'BaseTable',
        components: {
            expandDom: {
                functional: true,
                props: {
                    row: Object,
                    col: Object,
                    render: Function,
                    colIndex: [Number, String]
                },
                render(h, ctx) {
                    const randomIndex = Math.random().toString(35).replace('.', '')
                    const params = {
                        row: { ...ctx.props.row },
                        colIndex: ctx.props.colIndex || randomIndex
                    }
                    if (ctx.props.col) {
                        params.col = ctx.props.col
                    }
                    return ctx.props.render && ctx.props.render(h, params)
                }
            }
        },
        props: {
            data: {
                type: Array,
                default() {
                    return []
                }
            },
            columns: {
                type: Array,
                default() {
                    return []
                }
            },
            // eslint-disable-next-line vue/require-default-prop
            pagination: {
                type: [Object, Boolean]
            },
            options:{
                type: Object,
                default() {
                    return {
                        select:false
                    }
                },
            }

        },
        data() {
            return {
                tableAttrs: {},
                columnAttrs: [],
                paginationAttrs: {}
            }
        },
        watch: {
            pagination: {
                handler(val) {
                    this.getPagination()
                },
                deep: true
            }
        },
        created() {
            this.$nextTick(() => {
                this.init()
            })
        },
        methods: {
            init() {
                // 获取element table上的属性
                const tableAttrs = { }
                Object.keys(defaultTableAttrs).forEach(key => {
                    if (this.$attrs[key] !== undefined) {
                        tableAttrs[key] = this.$attrs[key]
                    }
                })
                this.tableAttrs = Object.assign({}, defaultTableAttrs, tableAttrs)

                // 获取element table col上的属性
                this.columnAttrs = this.columns.map(column => {
                    const obj = Object.assign({}, defaultColumn, column)
                    return obj
                })
            },
            getPagination() {
                // 获取element 分页属性
                const pagination = this.pagination
                let paginationAttrs = {}
                if (pagination) {
                    if (typeof pagination === 'object') {
                        paginationAttrs = {
                            ...defaultPagination,
                            ...pagination,
                            isPagination: true
                        }
                    } else {
                        paginationAttrs = {
                            ...defaultPagination,
                            isPagination: true
                        }
                    }
                }
                Object.keys(paginationAttrs).forEach(key => {
                    if (this.$attrs[key] !== undefined && key !== 'pagination') {
                        paginationAttrs[key] = this.$attrs[key]
                    }
                })
                this.paginationAttrs = paginationAttrs
            },
            handleSizeChange(pageSize) {
                this.$emit('size-change', pageSize)
            },
            handleCurrentChange(page) {
                this.$emit('current-change', page)
            }
        }
    }
</script>




