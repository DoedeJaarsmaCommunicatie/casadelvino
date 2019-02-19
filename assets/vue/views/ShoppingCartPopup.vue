<template lang="pug">
.position-fixed(v-if='show')
    section.bg-white.shopping_cart_popup.p-md-4.position-relative.pt-5
        button.btn.closing_button(@click="close"): i.fas.fa-times.fa-2x.text-prim
        header
            span.h3.mr-2.ml-2.text-prim Winkelwagentje
            span.text-muted.text-prim ({{ count }}) artikelen
        main(v-for="item in cart", :key="item.key")
            cart-item-component(:item="item", @update-finished="fetchData")
        footer
            div.border-bottom.pl-2.d-flex.justify-content-between
                span.text-prim Voor 15:00 besteld, vandaag verzonden
                span.pr-4.text-dark
                    span.mr-2 totaal
                    span &euro; {{ total }}
            div.d-flex.mt-2.mr-4
                a.btn.bg-primary-dark-30.text-white.ml-auto(href="/betalen") afrekenen
</template>

<script lang="ts">
// @ts-ignore
import CartItemComponent from "../components/addToCart/CartItemComponent.vue";
export default {
    name: "ShoppingCartPopup",
	components: { CartItemComponent },
	data() {
    	return {
    		cart: [],
            total: 0,
            count: 0,
            show: true,
        }
    },
    beforeMount(): void {
        this.fetchData();
	},
    methods: {
    	fetchData() {
			this.$store.dispatch('get_cart')
				.then(() => {
					this.cart = this.$store.getters.cart;
					this.count = this.$store.getters.cartCount;
					this.total = this.$store.getters.totalPrice;
				})
				.catch((err) => {
					console.error(err)
				})
        },
        close() {
			this.$emit('close-shopping-cart');
			this.show = false
        }
    }
};
</script>

<style scoped lang="sass">
$prim: #69796B
$sec: #E5EAE6

.text-prim
    color: $prim !important
.text-sec
    color: $sec !important
.bg-prim
    background: $prim !important
.bg-sec
    background: $sec !important

.position-fixed
    top: 50%
    left: 50%
    -webkit-transform: translateX(-50%) translateY(-50%)
    -moz-transform: translateX(-50%) translateY(-50%)
    -ms-transform: translateX(-50%) translateY(-50%)
    -o-transform: translateX(-50%) translateY(-50%)
    transform: translateX(-50%) translateY(-50%)
    z-index: 999
    text-align: unset
    
.closing_button
    position: absolute
    right: 2rem
    top: 1rem

.shopping_cart_popup
    width: 50vw
    -webkit-box-shadow: 0 3px 8px rgba(#333, 0.4)
    -moz-box-shadow: 0 3px 8px rgba(#333, 0.4)
    box-shadow: 0 3px 8px rgba(#333, 0.4)
    @media screen and (max-width: 768px)
        width: 100vw
        height: 100vh
</style>
