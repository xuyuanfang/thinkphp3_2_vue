<template>
  <div class="app-container">
    <el-table
      v-loading="listLoading"
      :data="list"
      border
      element-loading-text="Loading"
      :row-class-name="tableRowClassName"
    >
      <el-table-column align="center" label="序号" >
        <template slot-scope="scope">
          {{ scope.$index }}
        </template>
      </el-table-column>
      <el-table-column label="id">
        <template slot-scope="scope">
          {{ scope.row.id }}
        </template>
      </el-table-column>
      <el-table-column label="角色名称"  align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="操作" fixed="right">
        <template slot-scope="scope">
          <el-button
                  size="mini"
                  @click="handleEdit(scope.row.id)">编辑</el-button>
          <el-button
                  size="mini"
                  type="danger"
                  @click="handleDelete(scope.row.id)">删除</el-button>
        </template>
      </el-table-column>

    </el-table>

    <pagination v-show="total>0" :total="total" :pageSizes.sync="pageSizes" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="fetchData" />

  </div>
</template>

<script>
import { roleList } from '@/api/role'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination

export default {
  components: { Pagination },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'gray',
        deleted: 'danger'
      }
      return statusMap[status]
    }
  },
  data() {

    return {
      list: null,
      listLoading: true,
      listQuery: {
          page: 1,
          limit: 10
      },
      total: 0
    }
  },
  created() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      this.listLoading = true
        console.log(this.$route)
        if(this.$route.query.page){
            this.listQuery.page = parseInt(this.$route.query.page)
        }
        if(this.$route.query.limit){
            this.listQuery.limit = parseInt(this.$route.query.limit)
        }

      roleList(this.listQuery).then(response => {
        this.list = response.data
        this.total = parseInt(response.pageInfo.totalcount)
        this.listQuery.limit = parseInt(response.pageInfo.limit)
        this.listLoading = false
      })
    },
    handleFilter() {
        this.fetchData()
    },
    tableRowClassName({row, rowIndex}) {
        if ((rowIndex % 2) == 0) {
            return 'warning-row';
        } else {
            return 'success-row';
        }
        return '';
    }
  }
}
</script>
