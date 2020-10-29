<template>
  <background>
    <middle>
      {{ $route.params.provider }}
      {{ $route.query }}
    </middle>
  </background>
</template>

<script>
export default {
  path: '/login/:provider',
}
</script>

<style>

</style>