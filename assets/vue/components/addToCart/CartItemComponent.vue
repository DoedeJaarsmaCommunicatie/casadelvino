<template lang="pug">
.bg-sec.p-1.px-2.my-1.round-my-corners
    span {{ item.name }}
    span.font-weight-bold &euro; {{ item.price }}
    quantity-input(:product-id="item.id", :quantity="item.quantity")
    span.font-weight-bold &euro; {{ total }}
</template>

<script lang="ts">
// @ts-ignore
import QuantityInput from "./QuantityInput.vue";
export default {
    name: "CartItemComponent",
	components: { QuantityInput },
	props: {
    	item: {
    		type: Object,
            default: undefined
        }
    },
    computed: {
    	total() {
    		return (<number>this.item.quantity) * (<number>this.item.price)
        }
    }
};
</script>

<style scoped lang="sass">
.round-my-corners
    -webkit-border-radius: 5px
    -moz-border-radius: 5px
    border-radius: 5px
    font-weight: lighter
</style>
