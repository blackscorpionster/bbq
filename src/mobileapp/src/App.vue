<template>
  <MobileMain></MobileMain>
</template>

<script>
import MobileMain from './components/MobileMain';

export default {
  name: 'App',
  components: {
    MobileMain
  }, mounted() {
  }
}
</script>

<style scoped>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #FFFFFF;
  background-color: #8e8c8a;
}
</style>
