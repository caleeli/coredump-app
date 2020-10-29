<template>
  <table border="0" class="w-100 h-100">
    <tr>
      <td :class="contentClass"><slot /></td>
    </tr>
  </table>
</template>

<script>
export default {
  props: {
    contentClass: null,
  },
}
</script>

<style>

</style>