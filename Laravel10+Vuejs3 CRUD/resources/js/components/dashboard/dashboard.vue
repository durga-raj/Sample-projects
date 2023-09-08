<script>
import Layout from "../layouts/main.vue";
/**
 * Products component
 */
export default {
  page: {
    title: "Dashboard",
    meta: [{ name: "description", content: "base project" }],
  },
  components: {
    Layout,
  },
  mounted() {
  }
};
</script>
<template>
  <Layout>
    <div>
      <div class="row">
        <div class="col-12">
          <div class="page-title-box">
            <div class="page-title-right">
            </div>
            <h4 class="page-title">Dashboard</h4>
            <div class="row">
              <div class="card">
                <div class="card-body d-flex justify-content-center align-items-center" style="height: 65vh!important;">
                 <h2> Welcome to Employee Portal !!! </h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
