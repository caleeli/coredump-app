<template>
  <div class="borderlayout">
    <div class="borderlayout-north"><slot name="north"></slot></div>
    <div class="borderlayout-middle">
      <div class="borderlayout-west"><slot name="west"></slot></div>
      <div class="borderlayout-center"><slot></slot></div>
      <div class="borderlayout-east"><slot name="east"></slot></div>
    </div>
    <div class="borderlayout-south"><slot name="south"></slot></div>
  </div>
</template>

<script>
export default {
  mounted() {
  }
};
</script>

<style>
body {
  padding: 0;
  margin: 0;
}

.borderlayout {
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;
}

.borderlayout-north {
}

.borderlayout-middle {
  display: flex;
  flex: 1;
}

.borderlayout-west {
  display: flex;
}

.borderlayout-center {
  display: flex;
  flex-direction: column;
  flex: 1;
}

.borderlayout-east {
  display: flex;
}

.borderlayout-south {
}

@media only screen and (max-device-width: 812px) {
  .borderlayout-west {
    display: none;
  }
  .borderlayout-east {
    display: none;
  }
}
</style>
