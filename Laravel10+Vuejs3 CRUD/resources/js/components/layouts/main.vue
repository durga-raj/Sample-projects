<script>
  import headerPage from '../layouts/header.vue'
  import sidebarPage from '../layouts/sidebar.vue'
  import footerPage from '../layouts/footer.vue'
export default {
  components: { headerPage, sidebarPage, footerPage },
  setup() {
  
  },
  methods: {},
};
</script>

<template>
    <headerPage />
    <sidebarPage />

    <div class="content-page">
      <div class="content">
        

        <div class="container-fluid mb-60">
          <slot />
        </div>
      </div>

      <footerPage />
    </div>
</template>