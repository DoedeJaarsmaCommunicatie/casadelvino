<template lang="pug">
    section.floating-cart-popup
        span {{ product_name }} is toegevoegd aan je winkelmandje.
        div.d-flex.mt-2
            a.btn.bg-primary.text-white.ml-auto(href="/bestellen") afrekenen
        div.d-flex.mt-2
            button.btn.bg-white.border-primary.text-primary.ml-auto(@click.prevent="close", type="button") Verder winkelen
</template>

<script lang="ts">
  export default {
    name: "MobileCartPopup",
    data: () => ({
      show: false,
    }),
    props: {
      product_name: {
        type: String,
        default: "Het product",
      }
    },
    methods: {
      close(): void {
        this.$emit('close-shopping-cart');
        this.show = false;
      }
    }
  };
</script>

<style scoped lang="sass">
.floating-cart-popup
    position: fixed
    top: 10vh
    background: hsl(0, 100%, 100%)
    box-shadow: 1px 3px 6px rgba(51, 51, 51, 0.3)
    left: 3vw
    right: 4vw
    padding: 8px
    z-index: 50
</style>
