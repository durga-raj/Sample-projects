<template>
    <div :class="`alert alert-${type} alert-dismissible text-bg-${type} border-0 fade show`" role="alert">
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      <strong>{{ message }}</strong>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      message: String,
      type: {
      type: String,
      default: 'success'
    }
    }
  };
  </script>
  