<template>
  <div class="background w-100 h-100">
    <slot />
  </div>
</template>

<script>
export default {
}
</script>

<style scoped>
@media (orientation: landscape) {
  .background {
    background-image: url(../../images/background.jpg);
    background-size: 100% auto;
  }
}
@media (orientation: portrait) {
  .background {
    background-image: url(../../images/background.jpg);
    background-size: auto 100%;
  }
}
</style>
