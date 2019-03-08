<template>
  <div class="app">
    <div class="app-body">
      <div class="container-fluid">
        <b-nav>
          <b-nav-item>All contacts</b-nav-item>
          <b-nav-item>My favorites</b-nav-item>
        </b-nav>
      </div>
      <main class="main">
        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: 'full',
  data () {
    return {
      nav: null
    }
  }
}
</script>
